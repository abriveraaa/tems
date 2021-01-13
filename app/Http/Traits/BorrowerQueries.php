<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Borrower;
use App\Models\User;

use Carbon\Carbon;
use DataTables;
use Laratrust;
use Validator;
use Auth;

trait BorrowerQueries {

    public function index()
    {
        $data = Borrower::withTrashed()->with('borrowercourse')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
                $update = Auth::user()->hasPermission('borrower-update');
                $delete = Auth::user()->hasPermission('borrower-delete');
                if($row->reported_at == null){
                    if($update == true && $delete == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2" id="edit-borrower" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-borrower"><i class="fas fa-pen mr-2"></i>Edit</a>';

                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="ban-borrower" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-user-lock mr-2"></i>Ban</a>';
                        return $btn;
                    }else if($update == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2" id="edit-borrower" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-borrower"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '';
                        return $btn;
                    }else if($delete == true){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="ban-borrower" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-user-lock mr-2"></i>Ban</a>';
                        return $btn;
                    }else{
                        // $btn = '';
                        // $btn .= '';
                        // return $btn;

                    }
                }else{
                    if($delete == true || $update == true){
                    $btn = '';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-success btn-sm" id="res-borrower" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-user-check mr-2"></i>Unlock</a>';
                    return $btn;
                    }else{
                        // $btn = '';
                        // $btn .= '';
                        // return $btn;
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
        $course = $request->course;
        $college = $request->college;
        $image_name = $request->hidden_image;
        $image = $request->file('borrower_image');

        if($image != '') 
        {
            $rules = array(
                'borrower_image' => 'image|max:2048',
                'studnum' => 'bail|required|unique:borrowers,studnum',
                'firstname' => 'required',
                'lastname' => 'required',
                'contact' => 'bail|required|unique:borrowers,contact', 
                'sex' => 'required', 
                'year' => 'bail|required|integer|gte:1|lte:5', 
                'section' => 'required', 
            );

             $messages = array(
                'studnum.unique' => 'Student number is already taken. <br>',
                'studnum.required' => 'Student number is required. <br>',
                'firstname.required' => 'Firstname is required. <br>',
                'lastname.required' => 'Lastname is required. <br>',
                'contact.required' => 'Contact is required. <br>',
                'contact.unique' => 'Contact is already taken. <br>',
                'sex.required' => 'Sex is required. <br>',
                'year.required' => 'Year is required. <br>',
                'year.integer' => 'Year must be a number. <br>',
                'year.gte' => 'Year must be a greater than 0. <br>',
                'year.lte' => 'Year must be a less than 6. <br>',
                'section.required' => 'Section is required. <br>',
            );

            $validate = Validator::make($request->all(), $rules, $messages);

            if($validate->fails())
            {
                return response()->json(['error' => $validate->errors()->all()]);
            }

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/borrower'), $image_name);

        }
        
        else
        {
            $rules = array(
                'borrower_image' => 'image|max:2048',
                'studnum' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'contact' => 'bail|required|phone|unique:borrowers,contact', 
                'sex' => 'required', 
                'year' => 'bail|required|integer|gte:1|lte:5', 
                'section' => 'required', 
            );

             $messages = array(
                'studnum.required' => 'Student number is required. <br>',
                'firstname.required' => 'Firstname is required. <br>',
                'lastname.required' => 'Lastname is required. <br>',
                'contact.required' => 'Contact is required. <br>',
                'contact.phone' => 'Contact must be a valid contact number.<br>Please add area code if you are using telephone number',
                'contact.unique' => 'Contact is already taken. <br>',
                'sex.required' => 'Sex is required. <br>',
                'year.required' => 'Year is required. <br>',
                'year.integer' => 'Year must be a number. <br>',
                'year.gte' => 'Year must be a greater than 0. <br>',
                'year.lte' => 'Year must be a less than 6. <br>',
                'section.required' => 'Section is required. <br>',
            );

            $validate = Validator::make($request->all(), $rules, $messages);

            if($validate->fails())
            {
                return response()->json(['error' => $validate->errors()->all()]);
            }
        }

        $borrower = new Borrower;
        $borrower->image = $image_name;
        $borrower->studnum = ucwords(mb_strtoupper($request->studnum));
        $borrower->firstname = ucwords(mb_strtolower($request->firstname));
        $borrower->midname = ucwords(mb_strtolower($request->midname));
        $borrower->lastname = ucwords(mb_strtolower($request->lastname));
        $borrower->contact = $request->contact;
        $borrower->sex = $request->sex;
        $borrower->year = $request->year;
        $borrower->section = $request->section;
        $borrower->save();

        $borrower->borrowercourse()->sync($course, $borrower);
        $borrower->borrowercollege()->sync($college, $borrower);

    	return response()->json(["success" => "Borrower's record added successfully!"], 201);
    }

    public function show($borrower)
    {
        if(Borrower::whereId($borrower)->exists()) {
            $borrower = Borrower::whereId($borrower)->with('borrowercollege')->with('borrowercourse')->first();
    		return response()->json($borrower);
    	} else {
    		return response()->json([
    			"success" => "Borrower not found"
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
        $course = $request->course;
        $college = $request->college;
        $image_name = $request->hidden_image;
        $borrowerId = $request->borrower_id;
        $image = $request->file('borrower_image');

        if($image != '') 
        {
            $rules = array(
                'borrower_image' => 'image|max:2048',
                'studnum' => 'bail|required',
                'firstname' => 'required',
                'lastname' => 'required',
                'contact' => 'bail|required', 
                'sex' => 'required', 
                'year' => 'bail|required|integer|gte:1|lte:5', 
                'section' => 'required', 
            );

             $messages = array(
                'studnum.required' => 'Student number is required. <br>',
                'firstname.required' => 'Firstname is required. <br>',
                'lastname.required' => 'Lastname is required. <br>',
                'contact.required' => 'Contact is required. <br>',
                'sex.required' => 'Sex is required. <br>',
                'year.required' => 'Year is required. <br>',
                'year.integer' => 'Year must be a number. <br>',
                'year.gte' => 'Year must be a greater than 0. <br>',
                'year.lte' => 'Year must be a less than 6. <br>',
                'section.required' => 'Section is required. <br>',
            );

            $validate = Validator::make($request->all(), $rules, $messages);

            if($validate->fails())
            {
                return response()->json(['error' => $validate->errors()->all()]);
            }

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/borrower'), $image_name);

        }
        
        else
        {
            $rules = array(
                'borrower_image' => 'image|max:2048',
                'studnum' => 'required|unique:borrowers,studnum,'.$borrowerId,
                'firstname' => 'required',
                'lastname' => 'required',
                'contact' => 'bail|required|phone', 
                'sex' => 'required', 
                'year' => 'bail|required|integer|gte:1|lte:5', 
                'section' => 'required', 
            );

             $messages = array(
                'studnum.required' => 'Student number is required. <br>',
                'studnum.unique' => 'Student number has already been taken. <br>',
                'firstname.required' => 'Firstname is required. <br>',
                'lastname.required' => 'Lastname is required. <br>',
                'contact.required' => 'Contact is required. <br>',
                'contact.phone' => 'Contact must be a valid contact number.<br>Please add area code if you are using telephone number',
                'sex.required' => 'Sex is required. <br>',
                'year.required' => 'Year is required. <br>',
                'year.integer' => 'Year must be a number. <br>',
                'year.gte' => 'Year must be a greater than 0. <br>',
                'year.lte' => 'Year must be a less than 6. <br>',
                'section.required' => 'Section is required. <br>',
            );

            $validate = Validator::make($request->all(), $rules, $messages);

            if($validate->fails())
            {
                return response()->json(['error' => $validate->errors()->all()]);
            }
        }

        $borrower = Borrower::where('id', $borrowerId)->first();
        $borrower->image = $image_name;
        $borrower->studnum = ucwords(mb_strtoupper($request->studnum));
        $borrower->firstname = ucwords(mb_strtolower($request->firstname));
        $borrower->midname = ucwords(mb_strtolower($request->midname));
        $borrower->lastname = ucwords(mb_strtolower($request->lastname));
        $borrower->contact = $request->contact;
        $borrower->sex = $request->sex;
        $borrower->year = $request->year;
        $borrower->section = $request->section;
        $borrower->save();

        $borrower->borrowercourse()->sync($course, $borrower);
        $borrower->borrowercollege()->sync($college, $borrower);

    	return response()->json(["success" => "Borrower's record added successfully!"], 201);
    }

    public function destroy($borrower)
    {
        $borrowers = Borrower::where('id', $borrower)->first();
        $borrowers->reported_at = Carbon::now()->toDateTimeString();
        $borrowers->save();

        return response()->json([
            "success" => "Borrower banned succesfully!"
        ], 202);
    }

    public function restore($borrower)
    {
        $borrowers = Borrower::where('id', $borrower)->first();
        $borrowers->reported_at = null;
        $borrowers->save();

        return response()->json(['success'=>'Record unlocked successfully.']);
    }
}