<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\CategoriesResource;
use App\Models\Category;

use DataTables;
use Auth;

class ToolCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::withTrashed()->get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $update = Auth::user()->hasPermission('toolcategory-update');
                    $delete = Auth::user()->hasPermission('toolcategory-delete');
                    if($row->deleted_at == null){
                        if($update == true && $delete == true){
                            $btn = '<a href="javascript:void(0)" class="edit-categories btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#categories"><i class="fas fa-pen mr-2"></i>Edit</a>';
                            $btn .= '<a href="javascript:void(0)" class="del-categories btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                            return $btn;
                        }else if($update == true){
                            $btn = '<a href="javascript:void(0)" class="edit-categories btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#categories"><i class="fas fa-pen mr-2"></i>Edit</a>';
                            return $btn;
                        }else if($delete == true){
                            $btn = '<a href="javascript:void(0)" class="del-categories btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                            return $btn;
                        }else{
                            $btn = "";
                        }
                    }else {
                        if($delete == true){
                            $btn = '<a href="javascript:void(0)" class="res-categories btn btn-warning btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-file mr-2"></i>Restore</a>';
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
            'description' => 'bail|required|unique:categories,description',
        );

        $messages = array(
            'description.required' => 'Description is required. <br>',
            'description.unique' => 'Description has already been taken. <br>',
        );

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())  
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        else
        {
            Category::updateOrCreate(['id' => $request->id], ['description' => $request->description]);          
            return response()->json(['success'=>'Record added successfully.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Category $categories)
    {
        $categories = Category::find($categories);
        $data = CategoriesResource::collection($categories);
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
            'description' => 'bail|required|unique:categories,description,'.$request->id,
        );

        $messages = array(
            'description.required' => 'Tool category is required. <br>',
            'description.unique' => 'Category name has already been taken.<br>', 
        );

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())  
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        else
        {
            Category::find($request->id)
                    ->update(['description' => $request->description]);
            return response()->json(['success'=>'Record updated successfully.']);
        }
    }

    public function destroy($categories)
    {
        Category::whereId($categories)->delete();

        return response()->json(['success'=>'Record deleted successfully.']);
    }

    public function restore($categories)
    {
        Category::withTrashed()
            ->where('id', $categories)
            ->restore();

        return response()->json(['success'=>'Record restored successfully.']);
    }
}
