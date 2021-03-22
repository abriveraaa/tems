<?php

namespace App\Http\Traits;

use App\Models\College;

use DataTables;
use Auth;

trait CollegeQueries {

    public function collegeDataTable($college)
    {
        return Datatables::of($college)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $update = Auth::user()->hasPermission('college-update');
                $delete = Auth::user()->hasPermission('college-delete');
                if($row->deleted_at == null){
                    if($update == true && $delete == true){
                        $btn = '<a href="javascript:void(0)" class="edit-college btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#college"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '<a href="javascript:void(0)" class="del-college btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                    }else if($update == true){
                        $btn = '<a href="javascript:void(0)" class="edit-college btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#college"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '';
                    }else if($delete == true){
                        $btn = '<a href="javascript:void(0)" class="del-college btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                        $btn .= '';
                    }else{
                        $btn = '';
                    }
                } else {
                    if($delete == true){
                        $btn = '<a href="javascript:void(0)" class="res-college btn btn-warning btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-file mr-2"></i>Restore</a>';
                        $btn .= '';
                    }
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function allCollege()
    {
        $college = College::withTrashed()->get();

        return $college;
    }

    public function saveCollege($validated)
    {
        $college = new College;
        $college->description = $validated['description'];
        $college->code = strtoupper($validated['code']);
        $college->save();

        return $college;
    }
    
    public function getCollege($college)
    {
        $colleges = College::whereId($college)->get();

        return $colleges;
    }

    public function updateCollege($collegeId, $validated)
    {
        $college = College::where('id', $collegeId)->first();
        $college->description = $validated['description'];
        $college->code = strtoupper($validated['code']);
        $college->save();

        return $college;
    }
    
    public function deleteCollege($college)
    {
        $colleges = College::whereId($college)->delete();

        return $colleges;
    }

    public function restoreCollege($college)
    {
        $colleges = College::withTrashed()
        ->where('id', $college)
        ->restore();

        return $colleges;
    }
}
