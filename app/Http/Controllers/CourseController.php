<?php

namespace App\Http\Controllers;

use App\Http\Traits\CourseQueries;
use App\Http\Traits\SyncQueries;

use App\Http\Resources\CourseResource;
use App\Http\Requests\CourseRequest;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;

use DataTables;
use Validator;
use Auth;

class CourseController extends Controller
{
    use CourseQueries, SyncQueries;
       
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $course = $this->allCourse();
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

    public function store(CourseRequest $request)
    {

        $validated = $request->validated();

        $course = $this->saveCourse($validated);

        $this->syncCourse($request, $course);
        
        return response()->json(['success' => 'Course added successfully!']);
    }

    public function show($course)
    {
        $courses = $this->getCourse($course);
        $data = CourseResource::collection($courses);

        return response()->json($data);
    }

    public function update(CourseRequest $request)
    {
        $courseId = $request->id;

        $validated = $request->validated();

        $course = $this->updateCourse($courseId, $validated);

        $this->syncCourse($request, $course);
        
        return response()->json(['success'=>'Record updated successfully.']);
    }

    public function destroy($course)
    {
        $this->deleteCourse($course);

        return response()->json(['success'=>'Record deleted successfully.']);
    }

    public function restore($course)
    {
        $this->restoreCourse($course);

        return response()->json(['success'=>'Record restored successfully.']);
    }
    
}
