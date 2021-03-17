<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\Requests;
use App\Models\Tools;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use DB;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->date = Carbon::now()->format('mdY');
    }
    public function activeBorrower() {
        $data = Borrower::where('reported_at', '=', null)->with(['borrowercourse'])->get();

        $head = User::where('position', 'Laboratory Head')->first();

        $staff = User::where('position', 'Laboratory Staff')->first();

        view()->share('activeborrower', $data);
        $pdf = PDF::loadView('report.active-borrower', ['data' => $data, 'head' => $head, 'staff' => $staff]);
  
        return $pdf->download('TEMS_Active-Borrower_'.$this->date.'.pdf');
    }

    public function bannedBorrower() {
        $data = Borrower::where('reported_at', '<>', null)->with(['borrowercourse'])->get();

        $head = User::where('position', 'Laboratory Head')->first();

        $staff = User::where('position', 'Laboratory Staff')->first();

        view()->share('bannedborrower',$data);
        $pdf = PDF::loadView('report.banned-borrower', ['data' => $data, 'head' => $head, 'staff' => $staff]);
  
        return $pdf->download('TEMS_Banned-Borrower_'.$this->date.'.pdf');
    }

    public function serviceItem() {
        $data = Tools::with(['tooladmin', 'toolcategory', 'toolname', 'toolsource', 'toolreport'])->get();

        $head = User::where('position', 'Laboratory Head')->first();

        $staff = User::where('position', 'Laboratory Staff')->first();

        view()->share('serviceitem',$data);
        $pdf = PDF::loadView('report.serviceable-item', ['data' => $data, 'head' => $head, 'staff' => $staff])->setPaper('a4', 'landscape');  
        return $pdf->download('TEMS_Serviceable-Item_'.$this->date.'.pdf');
    }

    public function reportedItem() {
        $data = Tools::onlyTrashed()->with(['tooladmin', 'toolcategory', 'toolname', 'toolsource', 'toolreport'])->get();

        $head = User::where('position', 'Laboratory Head')->first();

        $staff = User::where('position', 'Laboratory Staff')->first();

        view()->share('reporteditem',$data);
        $pdf = PDF::loadView('report.reported-item', ['data' => $data, 'head' => $head, 'staff' => $staff])->setPaper('a4', 'landscape');
  
        return $pdf->download('TEMS_Reported-Item_'.$this->date.'.pdf');
    }

    public function usageItem($startdate, $enddate)
    {
		$start = Carbon::parse($startdate)->format('Y-m-d ').'00:00:00';
        $end = Carbon::parse($enddate)->format('Y-m-d ').'23:59:59';

        $datestart = Carbon::parse($startdate)->isoFormat('MMMM D, YYYY');
        $dateend = Carbon::parse($enddate)->isoFormat('MMMM D, YYYY');
        if($datestart == $dateend){
            $date = Carbon::parse($startdate)->isoFormat('MMMM D, YYYY');
        } else {
            $date = Carbon::parse($startdate)->isoFormat('MMMM D, YYYY').' - '. Carbon::parse($enddate)->isoFormat('MMMM D, YYYY');
        }
        
        $head = User::where('position', 'Laboratory Head')->first();

        $staff = User::where('position', 'Laboratory Staff')->first();

        $data = DB::SELECT("SELECT requests.created_at, tool_names.id, tool_names.description, COUNT( tool_names.id ) AS count
        FROM tool_names
        INNER JOIN request_item ON tool_names.id = request_item.tool_name_id
        INNER JOIN requests ON requests.id = request_item.requests_id
        WHERE requests.status = 'Returned' AND requests.created_at BETWEEN '$start' AND '$end'
        GROUP BY tool_name_id");

        view()->share('usageitem',['data' => $data, 'date' => $date]);
        $pdf = PDF::loadView('report.usage-item', ['data' => $data, 'date' => $date, 'head' => $head, 'staff' => $staff]);
        return $pdf->download('TEMS_Usage-Item_'.$this->date.'.pdf');    
    }

    public function lhofBorrower(Request $request)
    {
        $lhofId = $request->dat;
        $data = Requests::where('lhof', $lhofId)->with(['borrowers', 'courses', 'item', 'room', 'borrows', 'returns'])->withCount('item')->get();

        view()->share('lhofborrower',$data);
        $pdf = PDF::loadView('report.lhof-borrower', $data)->setPaper('a6', 'portrait');
  
        return $pdf->download('TEMS_LHOF-Borrower_'.$this->date.'.pdf');
    }

    public function barcodeItem($id)
    {
        $data = Tools::where('id',$id)->with(['tooladmin', 'toolcategory', 'toolname', 'toolsource', 'toolreport'])->get();

        view()->share('barcodeitem',$data);
        $pdf = PDF::loadView('report.barcode-item', $data)->setPaper('a7', 'landscape');
  
        return $pdf->download('TEMS_Barcode-Item_'.$this->date.'.pdf');
    }

    public function allBarcode()
    {
        $data = Tools::with(['toolcategory', 'toolname'])->get();

        view()->share('barcode',$data);
        $pdf = PDF::loadView('report.barcode-all', $data)->setPaper('a7', 'landscape');
  
        return $pdf->download('TEMS_AllBarcode_'.$this->date.'.pdf');
    }
    
    public function inventory($startdate, $enddate)
    {
		$start = Carbon::parse($startdate)->format('Y-m-d ').'00:00:00';
        $end = Carbon::parse($enddate)->format('Y-m-d ').'23:59:59';
       
        $datestart = Carbon::parse($startdate)->isoFormat('MMMM D, YYYY');
        $dateend = Carbon::parse($enddate)->isoFormat('MMMM D, YYYY');
        if($datestart == $dateend){
            $date = Carbon::parse($startdate)->isoFormat('MMMM D, YYYY');
        } else {
            $date = Carbon::parse($startdate)->isoFormat('MMMM D, YYYY').' - '. Carbon::parse($enddate)->isoFormat('MMMM D, YYYY');
        }        

        $head = User::where('position', 'Laboratory Head')->first();

        $staff = User::where('position', 'Laboratory Staff')->first();
        
        $datas = DB::SELECT("SELECT A.id, IFNULL((D.previous_count - B.deleted_count), IFNULL(D.previous_count, 0)) AS previous, A.category, A.itemname, IFNULL(C.added_count, 0) AS quantityadded,IFNULL(E.losts_count, 0) AS lost_count, IFNULL(F.damages_count, 0) AS damaged_count, 
         IFNULL(D.previous_count - B.deleted_count, IFNULL(D.previous_count, 0)) + IFNULL(C.added_count, 0) - IFNULL(E.losts_count, 0) - IFNULL(F.damages_count, 0) as quantityonhand FROM
                            (SELECT tool_names.id, tool_names.description AS itemname, categories.description AS category FROM tool_names
                            INNER JOIN tool_toolnames ON tool_names.id = tool_toolnames.tool_name_id
                            INNER JOIN tools ON tools.id = tool_toolnames.tools_id
                            INNER JOIN category_toolnames ON category_toolnames.tool_name_id = tool_names.id
                            INNER JOIN categories ON categories.id = category_toolnames.category_id
                            WHERE tools.created_at <= '$end'
                            GROUP BY tool_names.id) A
                            LEFT OUTER JOIN
                            (SELECT tool_names.id, COUNT(tool_names.id) AS deleted_count FROM tool_names
                            INNER JOIN tool_toolnames ON tool_names.id = tool_toolnames.tool_name_id
                            INNER JOIN tools ON tools.id = tool_toolnames.tools_id
                            INNER JOIN category_toolnames ON category_toolnames.tool_name_id = tool_names.id
                            INNER JOIN categories ON categories.id = category_toolnames.category_id
                            WHERE tools.deleted_at < '$start'
                            GROUP BY tool_names.id) B
                            ON A.id = B.id
                            LEFT OUTER JOIN
                            (SELECT tool_names.id, COUNT(tool_names.id) AS added_count FROM tool_names
                            INNER JOIN tool_toolnames ON tool_names.id = tool_toolnames.tool_name_id
                            INNER JOIN tools ON tools.id = tool_toolnames.tools_id
                            INNER JOIN category_toolnames ON category_toolnames.tool_name_id = tool_names.id
                            INNER JOIN categories ON categories.id = category_toolnames.category_id
                            WHERE tools.created_at BETWEEN '$start' AND '$end'
                            GROUP BY tool_names.id) C
                            ON A.id = C.id
                            LEFT OUTER JOIN
                            (SELECT tool_names.id, COUNT(tool_names.id) AS previous_count FROM tool_names
                            INNER JOIN tool_toolnames ON tool_names.id = tool_toolnames.tool_name_id
                            INNER JOIN tools ON tools.id = tool_toolnames.tools_id
                            INNER JOIN category_toolnames ON category_toolnames.tool_name_id = tool_names.id
                            INNER JOIN categories ON categories.id = category_toolnames.category_id
                            WHERE tools.created_at < '$start'
                            GROUP BY tool_names.id) D
                            ON A.id = D.id
                            LEFT OUTER JOIN
                            (SELECT tool_names.id, COUNT(tool_names.id) AS losts_count FROM tool_names
                            INNER JOIN tool_toolnames ON tool_names.id = tool_toolnames.tool_name_id
                            INNER JOIN tools ON tools.id = tool_toolnames.tools_id
                            INNER JOIN category_toolnames ON category_toolnames.tool_name_id = tool_names.id
                            INNER JOIN categories ON categories.id = category_toolnames.category_id
                            WHERE tools.reason = 'Lost' AND tools.deleted_at BETWEEN '$start' AND '$end'
                            GROUP BY tool_names.id) E
                            ON A.id = E.id
                            LEFT OUTER JOIN
                            (SELECT tool_names.id, COUNT(tool_names.id) AS damages_count FROM tool_names
                            INNER JOIN tool_toolnames ON tool_names.id = tool_toolnames.tool_name_id
                            INNER JOIN tools ON tools.id = tool_toolnames.tools_id
                            INNER JOIN category_toolnames ON category_toolnames.tool_name_id = tool_names.id
                            INNER JOIN categories ON categories.id = category_toolnames.category_id
                            WHERE tools.reason = 'Damaged' AND tools.deleted_at BETWEEN '$start' AND '$end'
                            GROUP BY tool_names.id) F
                            ON A.id = F.id
                            ");

        $data = array();

        foreach ($datas as $key => $item) {
           $data[$item->category][$key] = $item;
        }

    	view()->share('inventory',['data' => $data, 'date' => $date]);
        $pdf = PDF::loadView('report.inventory', ['data' => $data, 'date' => $date, 'head' => $head, 'staff' => $staff]);
        return $pdf->download('TEMS_Inventory_'.$this->date.'.pdf');    
    }
}
