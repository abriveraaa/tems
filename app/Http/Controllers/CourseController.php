<?php

namespace App\Http\Controllers;

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
       
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return CourseResource::collection(Course::all());
        $data = Course::withTrashed()->with('colleges')->get();
        return Datatables::of($data)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $college = $request->college;
        
        $rules = array(
            'college' => 'required',
            'description' => 'required|unique:courses,description',
            'code' => 'required|unique:courses,code'
        );
        
        $messages = array(
            'college.required' => 'College is required.<br>',
            'description.required' => 'Course name is required.<br>',
            'description.unique' => 'Course name has already been taken.<br>',
            'code.required' => 'Course code is required.<br>',
            'code.unique' => 'Course code has already been taken.<br>',
        );
            
        $validate = Validator::make($request->all(), $rules, $messages);
            
        if($validate->fails()) {
            
            return response()->json(['error' => $validate->errors()->all()]);
        }else {
            $course = new Course();
            $course->description = $request->description;
            $course->code = strtoupper($request->code);
            $course->save();
            
            $course->colleges()->sync($college, $course);
            return response()->json(['success' => 'Course added successfully!']);
        }
    }

    public function show($course)
    {
        if(Course::whereId($course)->exists()) {
            $course = Course::whereId($course)->with('colleges')->first();
    		return response()->json($course);
    	} else {
    		return response()->json([
    			"success" => "Course not found"
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
        $college = $request->college;
        $course = $request->idcourse;
        
        $rules = array(
            'college' => 'required',
            'description' => 'required|unique:courses,description,'.$course,
            'code' => 'required|unique:courses,code,'.$course,
        );
        
        $messages = array(
            'college.required' => 'College is required.<br>',
            'description.required' => 'Course description is required.<br>',
            'code.required' => 'Course code is required.<br>',
            'code.unique' => 'Course code has already been taken.<br>',
            'description.unique' => 'Course name has already been taken.<br>',
        );

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())  
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        else
        {
            $data = Course::where('id', $course)->first();
            $data->description = $request->description;
            $data->code = strtoupper($request->code);
            $data->save();

            $data->colleges()->sync($college,$course);
            
            return response()->json(['success'=>'Record updated successfully.']);
        }
    }

    public function destroy($course)
    {
        Course::whereId($course)->delete();

        return response()->json(['success'=>'Record deleted successfully.']);
    }

    public function restore($course)
    {
        Course::withTrashed()
            ->where('id', $course)
            ->restore();

        return response()->json(['success'=>'Record restored successfully.']);
    }
    
}
