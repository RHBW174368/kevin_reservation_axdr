@extends('layouts.app')

@section('content')

<!-- Page content -->
<div class="content">
	<div class="row mt-3">
	    <div class="col col-md-8">
	    	<button class="btn btn-md btn-danger">Add Room</button>
			<table class="mt-5 table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Room Name</th>
						<th scope="col">Room Description</th>
						<th scope="col">Active</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($rooms as $room)
					<tr>
						<th scope="row" data-attrib="{{ $room->id }}">{{ $room->id }}</th>
						<td>{{ $room->room_name }}</td>
						<td>{{ $room->description }}</td>
						<td>{{ $room->active == 1 ? 'yes' : 'no' }}</td>
						<td>
							<!-- <button name="edit" class="btn btn-sm btn-success">Edit</button>
							<button name="delete" class="btn btn-sm btn-danger">Delete</button> -->
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
    	</div>
  	</div>
</div>

<script>
	
</script>

@endsection