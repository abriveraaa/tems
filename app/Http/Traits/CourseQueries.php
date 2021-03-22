<?php

namespace App\Http\Traits;

use App\Models\Course;

use DataTables;
use Auth;

trait CourseQueries {

    public function courseDataTable($course)
    {
        return Datatables::of($course)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $update = Auth::user()->hasPermission('course-update');
                $delete = Auth::user()->hasPermission('course-delete');
                if($row->deleted_at == null){
                    if($update == true && $delete == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2" id="edit-course" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-course"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="del-course" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                        return $btn;
                    }else if($update == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2" id="edit-course" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-course"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '';
                        return $btn;
                    }else if($delete == true){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="del-course" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                        return $btn;
                    }else{
                        $btn = '';
                    }
                }else{
                    if($delete == true){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-success btn-sm" id="res-course" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-trash-restore mr-2"></i>Restore</a>';
                        return $btn;
                    }else{

                    }
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function allCourse()
    {
        $course = Course::withTrashed()->with('colleges')->get();

        return $course;
    }

    public function saveCourse($validated)
    {
        $course = new Course();
        $course->description = $validated['description'];
        $course->code = strtoupper($validated['code']);
        $course->save();

        return $course;
    }

    public function getCourse($course)
    {
        $courses = Course::whereId($course)->with('colleges')->get();

        return $courses;
    }

    public function updateCourse($courseId, $validated)
    {
        $course = Course::where('id', $courseId)->first();
        $course->description = $validated['description'];
        $course->code = strtoupper($validated['code']);
        $course->save();

        return $course;
    }

    public function deleteCourse($course)
    {
        $courses = Course::whereId($course)->delete();

        return $courses;
    }

    public function restoreCourse($course)
    {
        $courses = Course::withTrashed()
        ->where('id', $course)
        ->restore();

        return $courses;
    }
}