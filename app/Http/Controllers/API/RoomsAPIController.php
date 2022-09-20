<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Rooms;
use JWTAuth;

class RoomsAPIController extends Controller
{
	// get: api/rooms/
	public function index() 
    {
    	$rooms = Rooms::where('active',1)
            ->orderBy('room_name','ASC')
            ->get();
        return $rooms;
    }

    // post: api/rooms
    public function store(Request $request)
    {
        $room = new Rooms([
            'room_name' => $request->input('room_name');
        ]);
        $room->save();
        return response()->json([
            "message" => "Successfully Created!",
            "message_status" => "success",
        ], 200);
    }

    // put: api/rooms/1
    public function update($id, Request $request)
    {
        $room = Rooms::find($id);
        $room->update($request->all());
        return response()->json('Successfully Updated!');
    }

    // get: api/rooms/id
    public function show($id)
    {
    	$room = Rooms::find($id);
    	return response()->json($room);
    }

    // delete: api/rooms/id
    public function destroy($id)
    {
    	$rooms = Rooms::find($id);
    	$rooms->delete();
    	return response()->json([
			"message" => "Successfully Deleted!",
			"message_status" => "success"
		], 200);
    }
}
