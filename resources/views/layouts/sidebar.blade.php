<!-- The sidebar -->
<div class="sidebar">
  <a class="{{ (request()->is('/')) ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
  <a class="{{ (request()->is('booking')) ? 'active' : '' }}" href="{{ route('booking.index') }}">Bookings</a>
  <a href="#contact">Contact</a>
  <a href="#about">About</a>
</div>