<?php

namespace App\Http\Traits;

use App\Models\ToolName;

use DataTables;
use Auth;

trait ToolNameQueries {

    public function allToolName()
    {
        $toolname = ToolName::withTrashed()->with('categories')->get();

        return $toolname;
    }

    public function toolNameDataTable($toolname)
    {
        return Datatables::of($toolname)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $update = Auth::user()->hasPermission('toolname-update');
                $delete = Auth::user()->hasPermission('toolname-delete');
                if($row->deleted_at == null){
                    if($update == true && $delete == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2" id="edit-toolname" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-toolname"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="del-toolname" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                        return $btn;
                    }else if($update == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2" id="edit-toolname" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-toolname"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        return $btn;
                    }else if($delete == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="del-toolname" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                        return $btn;
                    }else{
                        $btn = "";
                    }
                }else{
                    if($delete == true){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-success btn-sm" id="res-toolname" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-trash-restore mr-2"></i>Restore</a>';
                        return $btn;
                    }
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function saveToolName($validated)
    {
        $toolname = new ToolName();
        $toolname->description = $validated['description'];
        $toolname->save();

        return $toolname;
    }

    public function getToolName($toolnameId)
    {
        $toolname = ToolName::whereId($toolnameId)->with('categories')->first();

        return $toolname;
    }

    public function updatedToolName($toolNameId, $validated)
    {
        $toolname = ToolName::where('id', $toolNameId)->first();
        $toolname->description = $validated['description'];
        $toolname->save();

        return $toolname;
    }

    public function deleteToolName($toolNameId)
    {
        $toolname = ToolName::whereId($toolNameId)->delete();

        return $toolname;
    }

    public function restoreToolName($toolNameId)
    {
        $toolname = ToolName::withTrashed()
        ->where('id', $toolNameId)
        ->restore();

        return $toolname;
    }
}