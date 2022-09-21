@auth 
	<!-- The sidebar -->
	<div class="sidebar">
		<a class="{{ (request()->is('/')) ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
		@if(Auth::user()->role_id == 1)
		<a class="{{ (request()->is('rooms')) ? 'active' : '' }}" href="{{ route('rooms.index') }}">Rooms</a>
		@endif
		<a class="{{ (request()->is('booking')) ? 'active' : '' }}" href="{{ route('booking.index') }}">Bookings</a>
	</div>
	
@endauth