<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ToolName;

use DataTables;
use Validator;
use Auth;

class ToolNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ToolName::withTrashed()->with('categories')->get();
        return Datatables::of($data)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $toolcategory = $request->toolcategory;
        
        $rules = array(
            'toolcategory' => 'required',
            'description' => 'required|unique:tool_names,description',
        );
        
        $messages = array(
            'toolcategory.required' => 'Tool category is required.<br>',
            'description.required' => 'Tool name is required.<br>',
            'description.unique' => 'Tool name has already been taken.<br>',
        );
            
        $validate = Validator::make($request->all(), $rules, $messages);
            
        if($validate->fails()) {
            
            return response()->json(['error' => $validate->errors()->all()]);
        }else {
            $toolname = new ToolName();
            $toolname->description = $request->description;
            $toolname->save();
            
            $toolname->categories()->sync($toolcategory, $toolname);
            return response()->json(['success' => 'Tool name added successfully!']);
        }
    }

    public function show($toolName)
    {
        if(ToolName::whereId($toolName)->exists()) {
            $toolName = ToolName::whereId($toolName)->with('categories')->first();
    		return response()->json($toolName);
    	} else {
    		return response()->json([
    			"success" => "Tool Name not found"
    		], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $toolcategory = $request->toolcategory;
        $toolcategory = $request->toolcategory;
        $toolname = $request->idtoolname;

        
        $rules = array(
            'toolcategory' => 'required',
            'description' => 'required|unique:tool_names,description,'.$toolname,
        );
        
        $messages = array(
            'toolcategory.required' => 'Tool category is required.<br>',
            'description.required' => 'Tool name is required.<br>',
            'description.unique' => 'Tool name has already been taken.<br>',
        );
            
        $validate = Validator::make($request->all(), $rules, $messages);
            
        if($validate->fails()) {
            
            return response()->json(['error' => $validate->errors()->all()]);
        }else {
           
            $toolname = ToolName::where('id', $toolname)->first();
            $toolname->description = $request->description;
            $toolname->save();
            
            $toolname->categories()->sync($toolcategory, $toolname);
            return response()->json(['success' => 'Tool name updated successfully!']);
        }
    }

    public function destroy($toolname)
    {
        ToolName::whereId($toolname)->delete();

        return response()->json(['success'=>'Record deleted successfully.']);
    }

    public function restore($toolname)
    {
        ToolName::withTrashed()
            ->where('id', $toolname)
            ->restore();

        return response()->json(['success'=>'Record restored successfully.']);
    }
}
