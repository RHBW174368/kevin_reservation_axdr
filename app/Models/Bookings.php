<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Bookings extends Model
{
    use HasFactory;

    public function checkAvailability($room_id,$booking_start,$booking_end,$is_edit = null)
    {
    	$result = Bookings::where('room_id',$room_id)
    		->whereDate('booking_start',date('Y-m-d', strtotime($booking_start)))
    		->where('booking_start','<',$booking_end)
    		->where('booking_end','>',$booking_start);

    	/* Ignore Availability Check if Updating Existing Record*/
    	$result->when($is_edit != "", function($q) use ($is_edit){
    		return $q->where('id','<>',$is_edit);
    	});

    	$result->get();

    	return $result->count();	
    }

    public function saveBooking($room_id,$booking_start,$booking_end,$user_id)
    {
    	try
    	{
	    	$booking = new Bookings();
	    	$booking->room_id = $room_id;
	    	$booking->user_id = $user_id;
	    	$booking->booking_start = $booking_start;
	    	$booking->booking_end = $booking_end;
	    	$booking->save();

	    	return response()->json([
				"message" => "Successfully Saved Booking!",
				"message_status" => "success",
				"data" => $booking
			],200);
    	}catch(\Exception $e){

    		return response()->json([
    			"message" => "Booking Failed! " . $e->getMessage(),
    			"message_status" => "failed"
    		],500);
    	}
    }

    public function updateBooking($room_id,$booking_start,$booking_end,$user_id,$booking_id)
    {
    	try
    	{
	    	$booking = Bookings::where('id',$booking_id)
	    		->where('user_id', Auth::id())
	    		->update([
	    			'room_id' => $room_id,
	    			'booking_start' => $booking_start,
	    			'booking_end' => $booking_end
	    		]);

	    	return response()->json([
				"message" => "Successfully Updated Booking!",
				"message_status" => "success",
				"data" => $booking
			],200);
    	}catch(\Exception $e){

    		return response()->json([
    			"message" => "Booking Update Failed! " . $e->getMessage(),
    			"message_status" => "failed"
    		],500);
    	}
    }

    public function getBookingByID($booking_id)
    {
    	$result = Bookings::select([
    			'id',
    			'room_id',
    			'booking_start',
    			'booking_end',
    			DB::raw("DATE(booking_start) AS start_date"),
    			DB::raw("TIME_FORMAT(booking_start, '%H:%i') AS start_time"),
    			DB::raw("MINUTE(TIMEDIFF(booking_end,booking_start)) AS duration")
    		])
    		->where('id',$booking_id)
    		->first();

    	return $result;
    }
}
