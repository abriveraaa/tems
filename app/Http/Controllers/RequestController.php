<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\Borrower;
use App\Models\Lhof;
use App\Models\Tools;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;

class RequestController extends Controller
{
    public function createRequestLog(Request $request)
    {
        $borrower = $request->borrower;
        $item = $request->hiddendesc;
        $room = $request->room;
        $borrow = $request->admin;
        $course = $request->course;

        $lhof = Lhof::updateOrCreate(['id' => $request->lhofid],['code' => $request->lhofhidden]);
              
        $requestlog = new Requests;
        $requestlog->lhof = strtoupper($request->lhofhidden);
        $requestlog->tool = strtoupper($request->search_item);
        $requestlog->status = "Borrowed";
        $requestlog->save();

        $requestlog->borrower()->sync($borrower, $requestlog);
        $requestlog->course()->sync($course, $requestlog);
        $requestlog->item()->sync($item, $requestlog);
        $requestlog->room()->sync($room, $requestlog);
        $requestlog->borrow()->sync($borrow, $requestlog);
        
        $changestat = Tools::where('barcode', strtoupper($request->search_item))->first();
        $changestat->reason = "Borrowed";
        $changestat->save(); 
    }

    public function BorrowedItem()
    {
        $lhofnum = Requests::where('status', 'Borrowed')->groupBy('lhof')->with(['borrower', 'item', 'room', 'borrow'])->get();
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


    public function getRequestLog($item, $borrower, $admin)
    {
        $borr = Requests::with(['borrower' => function($q) use($borrower) {
            $q->where('borrower_id', $borrower);
        }])
        ->whereHas('borrower', function ($q) use($borrower) {
            $q->where('borrowers.id', $borrower);
        }) 
        ->where('status', 'Borrowed')
        ->where('tool', $item)
        ->exists();
        
        if($borr){
            $requestdata = Requests::where('status', 'Borrowed')->where('tool', $item)->with(['borrower', 'item', 'room', 'borrow'])->get();
            $available = Tools::where('barcode', $item)->where('reason', 'Borrowed')->first();
            $available->reason = null;
            $available->save();

            $returned = Requests::where('tool', $item)->where('status', 'Borrowed')->first();
            $returned->status = "Returned";
            $returned->save();

            $returned->return()->sync($admin, $returned);
            
            // /// IF OVER 20:30:00 ////    
            $bannedhours = "20:30:00";
            $timenow = Carbon::now()->toTimeString();
            if($timenow >= $bannedhours){

                $banneduser = Borrower::where('id', $borrower)->first();
                $banneduser->reported_at = Carbon::now()->toDateTimeString();
                $banneduser->save();

                return response()->json(['banned' => true, 'data' => $requestdata]);
            }

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
