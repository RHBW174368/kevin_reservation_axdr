@extends('layouts.app')

@section('content')

<!-- Page content -->
<div class="content">
	<div class="row mt-3">
	    <div class="col col-md-4">
    		<h3>Book an Appointment</h3>
    		<div class="mb-3 mt-3">
				<label for="exampleFormControlInput1" class="form-label"><b>Select Room</b></label>
				<select name="room" class="form-select" aria-label="" required>
					<option selected>Select a Room</option>
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
						<button id="checkAvailabilityBtn" name="checkAvailabilityBtn" class="btn btn-md btn-primary">Save Booking</button>
					</div>
			    </div>
		  	</div>
	    </div>
	    <div class="col col-md-8">
			<table class="mt-5 table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Booked By</th>
						<th scope="col">Start Time</th>
						<th scope="col">End Time</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th scope="row">1</th>
						<td>Mark</td>
						<td>Otto</td>
						<td>@mdo</td>
						<td></td>
					</tr>
					<tr>
						<th scope="row">2</th>
						<td>Jacob</td>
						<td>Thornton</td>
						<td>@fat</td>
						<td></td>
					</tr>
					<tr>
						<th scope="row">3</th>
						<td>Larry</td>
						<td>the Bird</td>
						<td>@twitter</td>
						<td></td>
					</tr>
				</tbody>
			</table>
    	</div>
  	</div>
</div>

<script type="application/javascript"> 

	$(document).ready(function(){

		/* Check Room Availability */
		$("#checkAvailabilityBtn").on("click", function(){
			var date = $("input[name='start_date']").val();
			var room = $("select[name='room']").find(":selected").val();
			var start_time = $("input[name='start_time']").val();
			var duration = $("select[name='duration']").val();

			$.ajax({
				type: "POST",
				url: "{{ route('booking.validate-booking') }}/",
				dataType:"json",
				data: {
					'room': room,
					'start_date': date,
					'start_time': start_time,
					'duration': duration,
					"_token": "{{ csrf_token() }}",
				},
				success: function(response){
					console.log(response);
					//$( "#result" ).empty().append( response );
				},
				error: function(message){
					console.log(message.responseText);
				}
			});
		});
	});

</script>
@endsection