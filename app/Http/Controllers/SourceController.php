<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Source;

use App\Http\Resources\SourceResource;
use App\Http\Requests\SourceRequest;

use App\Http\Traits\SourceQueries;

use Laratrust;
use DataTables;
use Auth;

class SourceController extends Controller
{
    use SourceQueries;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Source::withTrashed()->get();
        return Datatables::of($data)
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

    public function store(SourceRequest $request)
    {
        $validated = $request->validated();
        
        $source = $this->saveSource($validated);
        
        return response()->json(['success'=>'Record added successfully.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source)
    {
        $sources = Source::find($source);
        $data = SourceResource::collection($sources);
        return response()->json($data);
    }


    public function update(SourceRequest $request)
    {
        $validated = $request->validated();
        
        $source = $this->updateSource($request->id, $validated);
        
        return response()->json(['success'=>'Record updated successfully.']);
    }

    public function destroy($source)
    {
        Source::whereId($source)->delete();

        return response()->json(['success'=>'Record deleted successfully.']);
    }

    public function restore($source)
    {
        Source::withTrashed()
            ->where('id', $source)
            ->restore();

        return response()->json(['success'=>'Record restored successfully.']);
    }
}
