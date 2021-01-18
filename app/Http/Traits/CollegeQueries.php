<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Http\Resources\CollegeResource;

use App\Models\College;

use Carbon\Carbon;
use DataTables;
use Laratrust;
use Validator;
use Auth;

trait CollegeQueries {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = CollegeResource::collection(College::all());
        $data = College::withTrashed()->get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $update = Auth::user()->hasPermission('college-update');
                    $delete = Auth::user()->hasPermission('college-delete');
                    if($row->deleted_at == null){
                        if($update == true && $delete == true){
                            $btn = '<a href="javascript:void(0)" class="edit-college btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#college"><i class="fas fa-pen mr-2"></i>Edit</a>';
                            $btn .= '<a href="javascript:void(0)" class="del-college btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                            return $btn;
                        }else if($update == true){
                            $btn = '<a href="javascript:void(0)" class="edit-college btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#college"><i class="fas fa-pen mr-2"></i>Edit</a>';
                            $btn .= '';
                            return $btn;
                        }else if($delete == true){
                            $btn = '<a href="javascript:void(0)" class="del-college btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                            $btn .= '';
                            return $btn;
                        }else{
                            $btn = '';
                            return $btn;
                        }
                    } else {
                        if($delete == true){
                            $btn = '<a href="javascript:void(0)" class="res-college btn btn-warning btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-file mr-2"></i>Restore</a>';
                            $btn .= '';
                            return $btn;
                        }
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
            'description' => 'bail|required|unique:colleges,description',
            'code' => 'bail|required|unique:colleges,code|max:10'
        );

        $messages = array(
            'description.required' => 'Description is required. <br>',
            'description.unique' => 'Description has already been taken. <br>',
            'code.required' => 'College code is required. <br>',
            'code.unique' => 'College code has already been taken',
        );

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())  
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        else
        {
            College::updateOrCreate(['id' => $request->id], ['description' => $request->description, 'code' => strtoupper($request->code)]);          
            return response()->json(['success'=>'Record added successfully.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function show(College $college)
    {
        $colleges = College::find($college);
        $data = CollegeResource::collection($colleges);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        
        $rules = array(
            'description' => 'bail|required|unique:colleges,description,'.$request->id,
            'code' => 'bail|required|max:10|unique:colleges,code,'.$request->id,
        );

        $messages = array(
            'description.required' => 'College name is required. <br>',
            'description.unique' => 'College name has already been taken. <br>',
            'code.required' => 'College code is required. <br>',
            'code.unique' => 'College code has already been taken',
        );

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())  
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        else
        {
            College::find($request->id)
                    ->update(['description' => $request->description, 'code' => strtoupper($request->code)]);
            return response()->json(['success'=>'Record updated successfully.']);
        }
        
    }

    public function destroy($college)
    {
        College::whereId($college)->delete();

        return response()->json(['success'=>'Record deleted successfully.']);
    }

    public function restore($college)
    {
        College::withTrashed()
            ->where('id', $college)
            ->restore();

        return response()->json(['success'=>'Record deleted successfully.']);
    }
    
}
