<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;

use App\Http\Traits\ToolCategoryQueries;
use App\Http\Traits\NotificationQueries;

class ToolCategoryController extends Controller
{
    use ToolCategoryQueries, NotificationQueries;

    public function __construct()
    {
        $this->model = 'Category';
    }

    public function index()
    {
        $category = $this->allCategory();
        
        $data = $this->categoryDataTable($category);

        return $data;
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        $category = $this->saveCategory($validated);     
        
        $response = $this->notify('success', $this->model, 'added successfully!');

        return $response;
    }

    public function show($categories)
    {
        $category = $this->getCategory($categories);
        
        return response()->json($category);
    }

    public function update(CategoryRequest $request)
    {
        $categoryId = $request->id;

        $validated = $request->validated();

        $category = $this->updateCategory($categoryId, $validated);

        $response = $this->notify('success', $this->model, 'updated successfully!');

        return $response;
                    
    }

    public function destroy($categories)
    {
        $this->deleteCategory($categories);

        $response = $this->notify('success', $this->model, 'deleted successfully!');

        return $response;
    }

    public function restore($categories)
    {
        $this->restoreCategory($categories);
        
        $response = $this->notify('success', $this->model, 'restored successfully!');

        return $response;
    }
}