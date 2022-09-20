<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    public function checkAvailability($room_id,$booking_start,$booking_end)
    {
    	$result = Bookings::where('room_id',$room_id)
    		->whereDate('booking_start',date('Y-m-d', strtotime($booking_start)))
    		->where('booking_start','<',$booking_end)
    		->where('booking_end','>',$booking_start)
    		->get();

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
}
