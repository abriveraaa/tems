<?php

namespace App\Http\Controllers;

use App\Http\Traits\NotificationQueries;
use App\Http\Traits\CourseQueries;
use App\Http\Traits\SyncQueries;
use App\Http\Requests\CourseRequest;

class CourseController extends Controller
{
    use CourseQueries, SyncQueries, NotificationQueries;

    public function __construct()
    {
        $this->model = 'Course';
    }
       
    public function index()
    {
        $course = $this->allCourse();
        
        $data = $this->CourseDataTable($course);

        return $data;
    }

    public function store(CourseRequest $request)
    {
        $validated = $request->validated();

        $course = $this->saveCourse($validated);

        $this->syncCourse($request, $course);
        
        $response = $this->notify($this->model, 'added');
        
        return $response;
    }

    public function show($course)
    {
        $courses = $this->getCourse($course);

        return response()->json($courses);
    }

    public function update(CourseRequest $request)
    {
        $courseId = $request->id;

        $validated = $request->validated();

        $course = $this->updateCourse($courseId, $validated);

        $this->syncCourse($request, $course);
        
        $response = $this->notify($this->model, 'updated');

        return $response;
    }

    public function destroy($course)
    {
        $this->deleteCourse($course);

        $response = $this->notify($this->model, 'deleted');

        return $response;
    }

    public function restore($course)
    {
        $this->restoreCourse($course);

        $response = $this->notify($this->model, 'restored');

        return $response;
    }
    
}
