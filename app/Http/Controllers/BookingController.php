<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooms;
use App\Models\Bookings;
use App\Http\Controllers\Helpers\ValidationHelper;
use Illuminate\Validation\ValidationException;
use Auth;

class BookingController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$rooms = Rooms::where('active',1)->get();

        return view('booking/index', compact('rooms'));
    }

    public function validateBooking(Request $request)
    {
    	/* Input Parameters Validation */
    	$request->validate([
            'room' => 'required|integer',
            'start_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|max:60|min:15',
        ]);
    	
    	$room_id = $request->room;
        $duration = $request->duration;
        $duration_formatted = "+". $duration ." minutes";
        $start_time = date("H:i", strtotime($request->start_time));
		$end_time = date("H:i", strtotime($duration_formatted, strtotime($start_time)));
        $booking_start = $request->start_date . " " . $start_time;
        $booking_end = $request->start_date . " " . $end_time;
        $is_weekend = ValidationHelper::isWeekend($booking_start);

        /* Business Rules Validation */
        if(strtotime($start_time) < strtotime('07:00') || strtotime($end_time) > strtotime('16:00'))
    	{
    		throw ValidationException::withMessages(['time' => 'Time should be between 7:00AM-4:00PM only!']);
    	}

        if($is_weekend)
    	{
    		throw ValidationException::withMessages(['start_date' => 'Selected date should be weekdays only!']);
    	}

        $is_taken = Bookings::checkAvailability($room_id,$booking_start,$booking_end);

        /* Save If Date/Time is Available */
        if(!$is_taken)
    	{
    		$bookings = Bookings::saveBooking($room_id,$booking_start,$booking_end,Auth::id());

    		return $bookings;
    	}else{
    		throw ValidationException::withMessages(['start_date' => 'Selected date is not available!']);
    	}
    }
}
