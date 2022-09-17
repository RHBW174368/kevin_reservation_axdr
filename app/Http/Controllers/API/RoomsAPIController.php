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
    	$rooms = Rooms::where('active',1)->get();

        return $rooms;
    }

    // get: api/rooms/id
    public function show($id)
    {
    	$room = Rooms::find($id);

    	return $room;
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
