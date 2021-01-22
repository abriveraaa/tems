<?php

namespace App\Http\Controllers;

use App\Http\Traits\CollegeQueries;

use App\Http\Resources\CollegeResource;
use App\Http\Requests\CollegeRequest;

use DataTables;
use Auth;

class CollegeController extends Controller
{
    use CollegeQueries;

    public function index()
    {
        $college = $this->allCollege();
        return Datatables::of($college)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $update = Auth::user()->hasPermission('college-update');
                    $delete = Auth::user()->hasPermission('college-delete');
                    if($row->deleted_at == null){
                        if($update == true && $delete == true){
                            $btn = '<a href="javascript:void(0)" class="edit-college btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#college"><i class="fas fa-pen mr-2"></i>Edit</a>';
                            $btn .= '<a href="javascript:void(0)" class="del-college btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                        }else if($update == true){
                            $btn = '<a href="javascript:void(0)" class="edit-college btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#college"><i class="fas fa-pen mr-2"></i>Edit</a>';
                            $btn .= '';
                        }else if($delete == true){
                            $btn = '<a href="javascript:void(0)" class="del-college btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                            $btn .= '';
                        }
                    } else {
                        if($delete == true){
                            $btn = '<a href="javascript:void(0)" class="res-college btn btn-warning btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-file mr-2"></i>Restore</a>';
                            $btn .= '';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function store(CollegeRequest $request)
    {

        $validated = $request->validated();

        $this->saveCollege($validated);
        
        return response()->json(['success'=>'Record added successfully.']);
    }

    public function show($college)
    {
        $colleges = $this->getCollege($college);

        $data = CollegeResource::collection($colleges);

        return response()->json($data);
    }

    public function update(CollegeRequest $request)
    {
        $validated = $request->validated();

        $this->updateCollege($request->id, $validated);

        return response()->json(['success'=>'Record updated successfully.']);
        
    }

    public function destroy($college)
    {
        $this->deleteCollege($college);

        return response()->json(['success'=>'Record deleted successfully.']);
    }

    public function restore($college)
    {
        $this->restoreCollege($college);

        return response()->json(['success'=>'Record deleted successfully.']);
    }
}
