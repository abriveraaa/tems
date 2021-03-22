<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToolnameRequest;
use App\Http\Traits\ToolNameQueries;
use App\Http\Traits\NotificationQueries;
use App\Http\Traits\SyncQueries;

class ToolNameController extends Controller
{
    use ToolNameQueries, SyncQueries, NotificationQueries;

    public function __construct()
    {
        $this->model = 'Tool name';
    }

    public function index()
    {
        $toolname = $this->allToolName();
        
        $data = $this->toolNameDataTable($toolname);

        return $data;
    }

    public function store(ToolnameRequest $request)
    {
        $toolcategory = $request->toolcategory;
        
        $validated = $request->validated();

        $toolname = $this->saveToolName($validated);

        $this->syncToolName($validated['toolcategory'], $toolname);

        $response = $this->notify($this->model, 'added');

        return $response;
    }

    public function show($toolNameId)
    {
        $toolname = $this->getToolName($toolNameId);

        return response()->json($toolname);
    }

    public function update(ToolnameRequest $request)
    {
        $validated = $request->validated();
                    
        $toolname = $this->updatedToolName($validated['idtoolname'], $validated);

        $this->syncToolName($validated['toolcategory'], $toolname);
            
        $response = $this->notify($this->model, 'updated');

        return $response;
    }

    public function destroy($toolNameId)
    {
        $this->deleteToolname($toolNameId);

        $response = $this->notify($this->model, 'deleted');

        return $response;
    }

    public function restore($toolNameId)
    {
        $toolname = $this->restoreToolName($toolNameId);

        $response = $this->notify($this->model, 'restored');

        return $response;
    }
}