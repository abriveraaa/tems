<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Traits\BorrowerQueries;
use App\Http\Requests\BorrowerRequest;

use App\Models\Borrower;

use Carbon\Carbon;
use DataTables;

class BorrowerController extends Controller
{
    use BorrowerQueries;

    public function __construct()
    {
        $this->date = Carbon::now()->toDateTimeString();
    }

    public function index()
    {
        $data = $this->allBorrower();

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
                $update = Auth::user()->hasPermission('borrower-update');
                $delete = Auth::user()->hasPermission('borrower-delete');
                if($row->reported_at == null){
                    if($update == true && $delete == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2" id="edit-borrower" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-borrower"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="ban-borrower" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-user-lock mr-2"></i>Ban</a>';
                    }else if($update == true){
                        $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2" id="edit-borrower" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-borrower"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '';
                    }else if($delete == true){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="ban-borrower" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-user-lock mr-2"></i>Ban</a>';
                    }
                }else{
                    if($delete == true || $update == true){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-success btn-sm" id="res-borrower" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-user-check mr-2"></i>Unlock</a>';
                    }
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(BorrowerRequest $request)
    {
        $validatedData = $request->validated();

        $image_name = $this->storeImage($request);
        
        $borrower = $this->saveBorrower($validatedData, $image_name);

        $this->syncAcademic($request, $borrower);

    	return response()->json(["success" => "Borrower's record added successfully!"], 201);
    }

    public function show($borrower)
    {
        $borrowers = $this->getBorrower($borrower);
            
        return response()->json($borrowers);
    }

    public function update(BorrowerRequest $request)
    {       
        $validatedData = $request->validated();

        $image_name = $this->storeImage($request);

        $borrower = $this->updateBorrower($request->borrower_id, $validatedData, $image_name);

        $this->syncAcademic($request, $borrower);

        return response()->json(["success" => "Borrower's record updated successfully!"], 201);
    }

    public function destroy($borrower)
    {
        $this->updateReport($borrower, $this->date);

        return response()->json(["success" => "Borrower banned succesfully!"], 201);
    }

    public function restore($borrower)
    {
        $this->updateReport($borrower, null);

        return response()->json(['success'=>'Record unlocked successfully.'], 201);
    }
}
