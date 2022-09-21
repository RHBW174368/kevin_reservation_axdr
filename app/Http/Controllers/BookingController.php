<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooms;
use App\Models\Bookings;
use App\Http\Controllers\Helpers\ValidationHelper;
use Illuminate\Validation\ValidationException;
use Auth;
use DataTables;

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
        $is_edit = $request->is_edit;
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
    		/* Update Record If Booking ID is Present */
    		if(empty($is_edit)) 
			{
    			$bookings = Bookings::saveBooking($room_id,$booking_start,$booking_end,Auth::id());
			}else{
				$bookings = Bookings::updateBooking($room_id,$booking_start,$booking_end,Auth::id(),$is_edit);
			}
    		return $bookings;
    	}else{
    		throw ValidationException::withMessages(['start_date' => 'Selected date is not available!']);
    	}
    }

    public function getBookings(Request $request)
    {
    	if($request->ajax())
		{
			$request->validate([
	            'room' => 'integer'
	        ]);

			$room_id = $request->room;
			$booking_date = $request->start_date;

			$query = Bookings::whereNotNull('user_id')
				->join('users','users.id','=','bookings.user_id')
				->join('rooms','rooms.id','=','bookings.room_id');

			$query->when($room_id != '', function($q) use ($room_id) {
				return $q->where('room_id',$room_id);
			});

			$query->when($booking_date != '', function($q) use ($booking_date) {
				return $q->whereDate('booking_start',date('Y-m-d', strtotime($booking_date)));
			});

			$data = $query->get([
				'name',
				'room_name',
				'booking_start',
				'booking_end',
				'user_id',
				'bookings.id as booking_id'
			]);

			return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                	if($row->user_id == Auth::id())
            		{
	                    $actionBtn = '<a href="javascript:void(0)" booking-id-attrib="'. $row->booking_id .'" class="editBooking btn btn-success btn-sm" >Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
	                    return $actionBtn;
                	}
                })
                ->rawColumns(['action'])
                ->make(true);
		}
    }
}
