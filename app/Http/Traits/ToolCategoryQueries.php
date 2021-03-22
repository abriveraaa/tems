<?php

namespace App\Http\Traits;

use App\Models\Category;

use DataTables;
use Auth;

trait ToolCategoryQueries {

    public function categoryDataTable($category)
    {
        return Datatables::of($category)
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

    public function allCategory()
    {
        $category = Category::withTrashed()->get();

        return $category;
    }

    public function saveCategory($validated)
    {
        $category = new Category();
        $category->description = $validated['description'];
        $category->save();

        return $category;
    }

    public function getCategory($categoryId)
    {
        $category = Category::find($categoryId);

        return $category;
    }

    public function updateCategory($categoryId, $validated)
    {
        $category = Category::where('id', $categoryId)->first();
        $category->description = $validated['description'];
        $category->save();

        return $category;
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::whereId($categoryId)->delete();

        return $category;
    }

    public function restoreCategory($categoryId)
    {
        $category = Category::withTrashed()
        ->where('id', $categoryId)
        ->restore();

        return $category;
    }
}