<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Http\Traits\NotificationQueries;
use App\Http\Traits\RoomQueries;

class RoomController extends Controller
{
    use RoomQueries, NotificationQueries;

    public function __construct()
    {
        $this->model = 'Room';
    }

    public function index()
    {
        $room = $this->allRoom();

        $data = $this->roomDataTable($room);

        return $data;
    }

    public function store(RoomRequest $request)
    {
        
        $validated = $request->validated();

        $room = $this->storeRoom($validated);

        $response = $this->notify($this->model, 'added');

        return $response;
    }

    public function show($roomId)
    {
        $room = $this->getRoom($roomId);

        return response()->json($room);
    }

    public function update(RoomRequest $request)
    {
        $validated = $request->validated();

        $this->updateRoom($request->id, $validated);

        $response = $this->notify($this->model, 'updated');

        return $response;
    }

    public function destroy($room)
    {
        $this->deleteRoom($room);

        $response = $this->notify($this->model, 'deleted');

        return $response;
    }

    public function restore($room)
    {
        $this->restoreRoom($room);

        $response = $this->notify($this->model, 'restored');

        return $response;
    }
}
