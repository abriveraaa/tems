<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Source;

use App\Http\Requests\SourceRequest;

use App\Http\Traits\SourceQueries;
use App\Http\Traits\NotificationQueries;

class SourceController extends Controller
{
    use SourceQueries, NotificationQueries;

    public function __construct()
    {
        $this->model = 'Source';
    }

    public function index()
    {
        $source = Source::withTrashed()->get();
        
        $data = $this->sourceDataTable($source);

        return $data;
    }

    public function store(SourceRequest $request)
    {
        $validated = $request->validated();
        
        $source = $this->saveSource($validated);
        
        $response = $this->notify($this->model, 'added');

        return $response;

    }

    public function show($source)
    {
        $sources = $this->getSource($source);

        return response()->json($sources);
    }


    public function update(SourceRequest $request)
    {
        $validated = $request->validated();
        
        $source = $this->updateSource($request->id, $validated);
        
        $response = $this->notify($this->model, 'updated');

        return $response;
    }

    public function destroy($source)
    {
        $this->deleteSource($source);

        $response = $this->notify($this->model, 'deleted');

        return $response;
    }

    public function restore($source)
    {
        $this->restoreSource($source);

        $response = $this->notify($this->model, 'restored');

        return $response;
    }
}
