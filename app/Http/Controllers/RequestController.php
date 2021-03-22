<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\Borrower;
use App\Models\Lhof;
use App\Models\Tools;

use Illuminate\Http\Request;

use App\Http\Traits\SyncQueries;
use App\Http\Traits\RequestQueries;
use App\Http\Traits\ToolQueries;

use Carbon\Carbon;
use DataTables;
use Auth;

class RequestController extends Controller
{
   use SyncQueries, RequestQueries, ToolQueries;

    public function createRequestLog(Request $request)
    {
        $adminId = Auth::user()->id;
        
        $lhof = Lhof::updateOrCreate(['id' => $request->lhofid],['code' => $request->lhofhidden]);
        
        $requestlog = $this->newRequest($request);

        $this->syncRequest($adminId, $request, $requestlog);
        
        $changestat = Tools::Barcode(strtoupper($request->search_item));
        
        $this->updateReason('Borrowed', $changestat);
    }

    public function BorrowedItem()
    {
        $lhofnum = Requests::GroupByLhof();

        return response()->json($lhofnum);
    }

    public function lhofDataGetUser()
    {
        $lhofdata = Requests::select(\DB::raw('COUNT(lhof) as item_count'),'lhof', 'id', 'tool', 'status', 'created_at', 'updated_at')->groupBy('lhof')->with(['borrower', 'item', 'room', 'borrow'])->get();

        return Datatables::of($lhofdata)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="view-lhof btn btn-primary btn-sm mr-2" data-id="'. $row->id .'" data-lhof="'.$row->lhof.'" data-toggle="modal" data-target="#lhof-data">View</a>';
                $btn .= '<a href="javascript:void(0)" class="print-lhof btn btn-danger btn-sm mr-2" data-id="'. $row->id .'" data-lhof="'.$row->lhof.'">Print</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);    
    }

    public function getRequestLog($item, $borrower)
    {
        $adminId = Auth::user()->id;
        $hasBorrower = Requests::HasBorrower($borrower, $item);
        
        if($hasBorrower){
            $requestdata = Requests::BorrowedItem($item);
            $available = Tools::Borrowed($item);
            $this->updateReason(null, $available);

            $returned = Requests::Borrowed($item);
            $this->updateStatus($returned, 'Returned');

            $this->syncRequestReturned($adminId, $returned);
            
            // IF OVER 20:30:00
            $date = $returned->created_at;
            $bannedDate =  Carbon::parse($date)->format('Y-m-d');
            $bannedhours = "20:30:00";
            $dateTimeString = $bannedDate." ".$bannedhours;
            $dueDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $dateTimeString, 'Asia/Manila');
            $timenow = Carbon::now();

            if($dueDateTime->lt($timenow)){ $this->updateReportedDate($borrower); }

            return response()->json(['status' => true, 'data' => $requestdata]);    
        }
        else {
            return response()->json(['status' => false]);
        }
    }

    public function itemLhof(Request $request)
    {
        $lhofId = $request->dat;

        $data = Requests::where('lhof', $lhofId)->with(['borrower', 'item', 'room', 'borrow', 'return'])->withCount('item')->get();

        return Datatables::of($data)
            ->make(true);    
    }
}
