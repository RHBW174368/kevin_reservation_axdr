$(document).ready(function(){
	var base_url = window.location.origin;
	/* Check Room Availability */
	$("#checkAvailabilityBtn").on("click", function(){
		var date = $("input[name='start_date']").val();
		var room = $("select[name='room']").find(":selected").val();
		var start_time = $("input[name='start_time']").val();
		var duration = $("select[name='duration']").val();
		var is_edit = $("input[name='is_edit']").val();
		var csrf_token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			type: "POST",
			url: base_url + '/booking/validate-booking/',
			dataType:"json",
			data: {
				'room': room,
				'start_date': date,
				'start_time': start_time,
				'duration': duration,
				'is_edit': is_edit,
				"_token": csrf_token,
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

	var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        	url: base_url + "/booking/list",
        	data: function(data){
	        	data.room = $("select[name='room']").find(":selected").val();
	        	data.start_date =  $("input[name='start_date']").val();
	        }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'room_name', name: 'room_name'},
            {data: 'booking_start', name: 'booking_start'},
            {data: 'booking_end', name: 'booking_end'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });

	/* Run Datatable on Change */
	$("input[name='start_date'],select[name='room']").on("change", function(){
		$('.yajra-datatable').DataTable().ajax.reload();
	});

	/* Fetch Booking by Booking ID */
	$(document).on("click", ".editBooking", function(e){
		var $elem = $(this);
		var booking_id = $elem.attr('booking-id-attrib');

		/* Set Booking ID to be Updated */
		$("input[name='is_edit']").val(booking_id);

		/* Fetch Selected Booking Info */
	});
	
});