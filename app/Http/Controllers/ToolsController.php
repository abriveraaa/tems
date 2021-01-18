<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tools;
use App\Models\Category;
use App\Models\Borrower;
use App\Models\Requests;

use Carbon\Carbon;
use DataTables;
use Validator;
use Auth;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Tools::with('toolname')->with(['tooladmin', 'toolcategory', 'toolname', 'toolroom'])->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $update = Auth::user()->hasPermission('tools-update');
                $delete = Auth::user()->hasPermission('tools-delete');
                if($row->deleted_at == null){
                    if($update == true && $delete == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm mr-2" id="edit-tools" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-tools"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="rep-tools" data-id="'. $row->id .'" data-toggle="modal" data-target="#report"><i class="fas fa-user-lock mr-2"></i>Report</a>';
                        return $btn;
                    }else if($update == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm mr-2" id="edit-tools" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-tools"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        return $btn;
                    }else if($delete == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="rep-tools" data-id="'. $row->id .'" data-toggle="modal" data-target="#report"><i class="fas fa-user-lock mr-2"></i>Report</a>';
                        return $btn;
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
        $description = $request->description;
        $room = $request->room;
        $category = $request->category;
        $admin = $request->admin_num;

        $rules = array(
            'category' => 'required',
            'description' => 'required',
            'barcode' => 'required',
            'room' => 'required',
            'property' => 'unique:tools,property',
        );

            $messages = array(
            'category.required' => 'Category is required. <br>',
            'description.required' => 'Description is required. <br>',
            'barcode.required' => 'Barcode is required. <br>',
            'room.required' => 'Room is required.<br>',
            'property.unique' => 'Property number has already been taken.<br>',
        );

        $validate = Validator::make($request->all(), $rules, $messages);

        if($validate->fails())
        {
            return response()->json(['error' => $validate->errors()->all()]);
        }else {
            $tools = new Tools;
            $tools->barcode = $request->barcode;
            $tools->brand = $request->brand;
            $tools->property = strtoupper($request->property);
            $tools->save();
    
            $tools->toolname()->sync($description, $tools);
            $tools->toolcategory()->sync($category, $tools);
            $tools->toolroom()->sync($room, $tools);
            $tools->tooladmin()->sync($admin, $tools);
    
            return response()->json(["success" => "Borrower's record added successfully!"], 201);
        }
    }

    public function show($tools)
    {
        if(Tools::whereId($tools)->exists()) {
            $tools = Tools::whereId($tools)->with('toolcategory')->with('toolname')->with('toolroom')->with('tooladmin')->first();
    		return response()->json($tools);
    	} else {
    		return response()->json([
    			"success" => "Tools not found"
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
        $description = $request->description;
        $toolId = $request->toolId;
        $room = $request->room;
        $category = $request->category;
        $admin = $request->admin_num;
       
        $rules = array(
            'category' => 'required',
            'description' => 'required',
            'barcode' => 'required|unique:tools,barcode,'.$toolId,
            'room' => 'required',
            'property' => 'unique:tools,property,'.$toolId,
        );

            $messages = array(
            'category.required' => 'Category is required. <br>',
            'description.required' => 'Description is required. <br>',
            'barcode.required' => 'Barcode is required. <br>',
            'room.required' => 'Room is required.<br>',
            'property.unique' => 'Property number has already been taken.<br>', 
            'barcode.unique' => 'Barcode number has already been taken.<br>', 
        );

        $validate = Validator::make($request->all(), $rules, $messages);

        if($validate->fails())
        {
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $tools = Tools::where('id', $toolId)->first();
        $tools->brand = $request->brand;
        $tools->property = strtoupper($request->property);
        $tools->save();

        $tools->toolname()->sync($description, $tools);
        $tools->toolcategory()->sync($category, $tools);
        $tools->toolroom()->sync($room, $tools);
        $tools->tooladmin()->sync($admin, $tools);
        
    	return response()->json(["success" => "Borrower's record updated successfully!"], 201);
    }

    public function report(Request $request)
    {
        $rules = array(
            'rep-borrower' => 'required',
            'repreason' => 'required',
        );

            $messages = array(
            'rep-borrower.required' => 'ID Number is required. <br>',
            'repreason.required' => 'Reason is required. <br>',
        );

        $validate = Validator::make($request->all(), $rules, $messages);

        if($validate->fails())
        {
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $borrower = $request->repnum;
        $toolId = $request->reptoolId;
        $barcode = $request->repBarcode;
        $admin = Auth()->user()->id;
        
        $check = Tools::where('id', $toolId)->where('reason', 'Borrowed')->exists();
        if($check){
            $returned = Requests::where('tool', $barcode)->where('status', 'Borrowed')->first();
            $returned->status = "Returned";
            $returned->save();

            $returned->return()->sync($admin, $returned);
        }
        
        $tools = Tools::whereId($toolId)->first();
        $tools->reason = $request->repreason;
        $tools->deleted_at = Carbon::now()->toDateTimeString();
        $tools->save();

        $tools->toolreport()->sync($borrower, $tools);
        $tools->tooladmin()->sync($admin, $tools);

        $banned = Borrower::whereId($borrower)->first();
        $banned->reported_at = Carbon::now()->toDateTimeString();
        $banned->save();

        return response()->json(["success" => "Tools reported successfully!"], 201);
    }
}
