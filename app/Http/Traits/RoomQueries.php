<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Room;

use Laratrust;
use DataTables;
use Auth;

trait RoomQueries {

    public function roomDatatable($room)
    {
        return Datatables::of($room)
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
                        $btn = "";
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

    public function allRoom()
    {
        $room = Room::withTrashed()->get();

        return $room;
    }

    public function getRoom($room)
    {
        $room = Room::whereId($room)->get();

        return $room;
    }

    public function storeRoom($validated)
    {
        $room = new Room();
        $room->description = ucwords(mb_strtolower($validated['description']));
        $room->code = strtoupper($validated['code']);
        $room->save();

        return $room;
    }

    public function updateRoom($roomId, $validated)
    {
        $room = Room::where('id', $roomId)->first();
        $room->description = ucwords(mb_strtolower($validated['description']));
        $room->code = strtoupper($validated['code']);
        $room->save();

        return $room;
    }

    public function deleteRoom($roomId)
    {
        $room = Room::whereId($roomId)->delete();

        return $room;
    }

    public function restoreRoom($roomId)
    {
        $room = Room::withTrashed()
            ->where('id', $roomId)
            ->restore();

        return $room;
    }

}