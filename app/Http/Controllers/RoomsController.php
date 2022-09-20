<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rooms;

class RoomsController extends Controller
{
	// get: api/rooms/
	public function index() 
    {
    	$rooms = Rooms::where('active',1)->get();
    	
        return view('rooms/index', compact('rooms'));
    }

    // get: api/rooms/id
    public function show($id)
    {
    	$room = Rooms::find($id);
    	
    	return view('rooms/index', compact('room'));
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
