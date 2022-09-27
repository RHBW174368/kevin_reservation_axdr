@extends('layouts.app')

@section('content')
<script src="{{ asset('js/bookings.js') }}"></script>
<!-- Page content -->
<div class="content">
	<div class="row mt-3">
	    <div class="col col-md-4">
    		<h3>Book an Appointment</h3>
    		<div class="mb-3 mt-3">
				<label for="exampleFormControlInput1" class="form-label"><b>Select Room</b></label>
				<select name="room" class="form-select" aria-label="" required>
					@foreach($rooms as $room)
					<option value="{{ $room->id }}">{{ $room->room_name }}</option>
					@endforeach
				</select>
			</div>
			<div class="mb-3">
				<label for="exampleFormControlTextarea1" class="form-label"><b>Booking Start Date</b></label>
				<input type="date" class="form-control" id="start_date" name="start_date" required/>
			</div>
			<div class="mb-3">
				<label for="exampleFormControlTextarea1" class="form-label"><b>Start Time</b></label>
				<input type="time" class="form-control" id="start_time" name="start_time" required/>
			</div>
			<div class="mb-3">
				<label for="exampleFormControlTextarea1" class="form-label"><b>Duration</b></label>
				<select name="duration" class="form-select" aria-label="" required>
					<option selected>--</option>
					@for($i = 15; $i <= 60; $i++)
						<option value="{{ $i }}">{{ $i }}</option>
					@endfor
				</select>
			</div>
			<div class="row">
			    <div class="col col-md-6">
		    		<div class="mb-3">
		    			<input type="hidden" name="is_edit" value=""/>
						<button id="checkAvailabilityBtn" name="checkAvailabilityBtn" class="btn btn-md btn-primary">Save Booking</button>
					</div>
			    </div>
			    <div class="col col-md-6">
					<div class="mb-3">
						<button id="clearFilter" name="clearFilter" class="btn btn-md btn-success">Reset Filters</button>
					</div>
			    </div>
		  	</div>
	    </div>
	    <div class="col col-md-8">
			<table class="mt-5 table table-striped yajra-datatable">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Booked By</th>
						<th scope="col">Room ID</th>
						<th scope="col">Booking Start</th>
						<th scope="col">Booking End</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
    	</div>
  	</div>
</div>
@endsection