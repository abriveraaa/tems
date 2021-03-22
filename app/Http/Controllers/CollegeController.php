<?php

namespace App\Http\Controllers;

use App\Http\Traits\NotificationQueries;
use App\Http\Traits\CollegeQueries;
use App\Http\Requests\CollegeRequest;

class CollegeController extends Controller
{
    use CollegeQueries, NotificationQueries;

    public function __construct()
    {
        $this->model = 'College';
    }

    public function index()
    {
        $college = $this->allCollege();
        
        $data = $this->collegeDataTable($college);

        return $data;
    }

    public function store(CollegeRequest $request)
    {
        $validated = $request->validated();

        $this->saveCollege($validated);

        $response = $this->notify($this->model, 'added');

        return $response;
    }

    public function show($college)
    {
        $colleges = $this->getCollege($college);

        return response()->json($colleges);
    }

    public function update(CollegeRequest $request)
    {
        $validated = $request->validated();

        $this->updateCollege($request->id, $validated);

        $response = $this->notify($this->model, 'updated');        

        return $response;
    }

    public function destroy($college)
    {
        $this->deleteCollege($college);

        $response = $this->notify($this->model, 'deleted');

        return $response;
    }

    public function restore($college)
    {
        $this->restoreCollege($college);

        $response = $this->notify($this->model, 'restored');

        return $response;
    }
}
