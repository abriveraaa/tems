<?php

namespace App\Http\Controllers;

use App\Models\Room;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Resources\RoomResource;

use Laratrust;
use Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Room::withTrashed()->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $update = Auth::user()->hasPermission('room-update');
                $delete = Auth::user()->hasPermission('room-delete');
                if($row->deleted_at == null){
                    if($update == true && $delete == true){
                        $btn = '<a href="javascript:void(0)" class="edit-room btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#room"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '<a href="javascript:void(0)" class="del-room btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                        return $btn;
                    }else if($update == true){
                        $btn = '<a href="javascript:void(0)" class="edit-room btn btn-success btn-sm mr-2" data-id="'. $row->id .'" data-toggle="modal" data-target="#room"><i class="fas fa-pen mr-2"></i>Edit</a>';
                        $btn .= '';
                        return $btn;
                    }else if($delete == true){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="del-room btn btn-danger btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-trash mr-2"></i>Delete</a>';
                        return $btn;
                    }else{

                    }
                }else {
                    if($delete == true){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="res-room btn btn-warning btn-sm" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-file mr-2"></i>Restore</a>';
                        return $btn;
                    }else{

                    }
                }

                
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'description' => 'bail|required|unique:rooms,description',
            'code' => 'bail|required|unique:rooms,code|max:10'
        );

        $messages = array(
            'description.required' => 'Description is required. <br>',
            'description.unique' => 'Description has already been taken. <br>',
            'code.required' => 'Room code is required. <br>',
            'code.unique' => 'Room code has already been taken',
        );

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())  
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        else
        {
            Room::updateOrCreate(['id' => $request->id], ['description' => ucwords(mb_strtolower($request->description)), 'code' => strtoupper($request->code)]);          
            return response()->json(['success'=>'Record added successfully.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        $rooms = Room::find($room);
        $data = RoomResource::collection($rooms);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $rules = array(
            'description' => 'bail|required',
            'code' => 'bail|required|max:10'
        );

        $messages = array(
            'description.required' => 'Description is required. <br>',
            'description.unique' => 'Description has already been taken. <br>',
            'code.required' => 'Room code is required. <br>',
            'code.unique' => 'Room code has already been taken',
        );

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())  
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        else
        {
            Room::find($request->id)
                    ->update(['description' => ucwords(mb_strtolower($request->description)), 'code' => strtoupper($request->code)]);
            return response()->json(['success'=>'Record updated successfully.']);
        }
    }

    public function destroy($room)
    {
        Room::whereId($room)->delete();

        return response()->json(['success'=>'Record deleted successfully.']);
    }

    public function restore($room)
    {
        Room::withTrashed()
            ->where('id', $room)
            ->restore();

        return response()->json(['success'=>'Record deleted successfully.']);
    }
}
