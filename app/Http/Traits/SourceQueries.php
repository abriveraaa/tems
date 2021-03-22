<?php

namespace App\Http\Traits;

use App\Models\Source;

use Laratrust;
use DataTables;
use Auth;

trait SourceQueries {

    public function sourceDataTable($source)
    {
        return Datatables::of($source)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $update = Auth::user()->hasPermission('source-update');
                $delete = Auth::user()->hasPermission('source-delete');
                if($row->deleted_at == null){
                    if($update == true && $delete == true){
                        $btn = '<a href="javascript:void(0)" class="edit-source btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#source"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '<a href="javascript:void(0)" class="del-source btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                        return $btn;
                    }else if($update == true){
                        $btn = '<a href="javascript:void(0)" class="edit-source btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#source"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '';
                        return $btn;
                    }else if($delete == true){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="del-source btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                        return $btn;
                    }else{
                        $btn = "";
                    }   
                }else {
                    if($delete == true){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="res-source btn btn-warning btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-file mr-2"></i>Restore</a>';
                        return $btn;
                    }else{

                    }
                } 
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function saveSource($validated)
    {
        $source = new Source();
        $source->description = ucwords(mb_strtolower($validated['description']));
        $source->save();

        return $source;
    }

    public function getSource($sourceId)
    {
        $source = Source::find($sourceId);

        return $source;
    }

    public function updateSource($sourceId, $validated)
    {
        $source = Source::where('id', $sourceId)->first();
        $source->description = ucwords(mb_strtolower($validated['description']));
        $source->save();

        return $source;
    }

    public function deleteSource($sourceId)
    {
        $source = Source::whereId($sourceId)->delete();

        return $source;
    }

    public function restoreSource($sourceId)
    {
        $source = Source::withTrashed()
            ->where('id', $sourceId)
            ->restore();

        return $source;
    }

}