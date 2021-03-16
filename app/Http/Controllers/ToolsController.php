<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\ToolQueries;
use App\Http\Traits\SyncQueries;

use App\Http\Requests\ToolRequest;

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
    use ToolQueries, SyncQueries;

    public function index()
    {

        $tools = $this->allTools();

        return Datatables::of($tools)
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
                    }else{
                        $btn = "";
                    }
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(ToolRequest $request)
    {
        $validated = $request->validated();

        $tools = $this->saveTools($validated);

        $this->syncTools($validated, $tools);

        return response()->json(["success" => "Tool's record added successfully!"], 201);
    }

    public function show($tools)
    {
        if(Tools::whereId($tools)->exists()) {
            $tool = $this->getTool($tools);
    		return response()->json($tool);
    	} else {
    		return response()->json([
    			"success" => "Tools not found"
    		], 404);
        }
    }

    public function update(ToolRequest $request)
    {
        $toolId = $request->toolId;

        $validated = $request->validated();
       
        $tools = $this->updateTool($validated, $toolId);

        $this->syncTools($validated, $tools);
        
    	return response()->json(["success" => "Tool's record updated successfully!"], 201);
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
