<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Tools;

use Carbon\Carbon;
use DataTables;
use Auth;

trait ToolQueries {

    public function toolDataTable($tools)
    {
        return Datatables::of($tools)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $update = Auth::user()->hasPermission('tools-update');
                $delete = Auth::user()->hasPermission('tools-delete');
                if($row->deleted_at == null){
                    if($update == true && $delete == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm mr-2" id="edit-tools" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-tools"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="rep-tools" data-id="'. $row->id .'" data-toggle="modal" data-target="#report"><i class="fas fa-user-lock mr-2"></i>Report</a>';
                        return $btn;
                    }else if($update == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm mr-2" id="edit-tools" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-tools"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        return $btn;
                    }else if($delete == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="rep-tools" data-id="'. $row->id .'" data-toggle="modal" data-target="#report"><i class="fas fa-user-lock mr-2"></i>Report</a>';
                        return $btn;
                    }else{
                        $btn = "";
                    }
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function allTools()
    {
        $tools = Tools::with('toolname')->with(['tooladmin', 'toolcategory', 'toolname', 'toolsource'])->get();

        return $tools;
    }

    public function saveTools($validated)
    {
        $tools = new Tools;
        $tools->barcode = $validated['barcode'];
        $tools->brand = $validated['brand'];
        $tools->property = strtoupper($validated['property']);
        $tools->save();

        return $tools;
    }

    public function updateTool($validated, $toolId)
    {
        $tools = Tools::where('id', $toolId)->first();
        $tools->brand = $validated['brand'];
        $tools->property = strtoupper($validated['property']);
        $tools->save();

        return $tools;
    }

    public function getTool($toolId)
    {
        $tool = Tools::whereId($toolId)->with(['toolcategory', 'toolname', 'toolsource', 'tooladmin'])->first();

        return $tool;
    }

    public function updateReason($reason, $changestat)
    {
        $changestat->reason = $reason;
        $changestat->save(); 

        return $changestat;
    }

    public function updateReportedTool($toolId, $validated)
    {
        $tools = Tools::whereId($toolId)->first();
        $tools->reason = $validated['repreason'];
        $tools->deleted_at = Carbon::now()->toDateTimeString();
        $tools->save();

        return $tools;
    }

}