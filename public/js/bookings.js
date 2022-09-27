$(document).ready(function(){

	var base_url = window.location.origin;
	var csrf_token = $('meta[name="csrf-token"]').attr('content');

	/* Check Room Availability */
	$("#checkAvailabilityBtn").on("click", function(){
		var date = $("input[name='start_date']").val();
		var room = $("select[name='room']").find(":selected").val();
		var start_time = $("input[name='start_time']").val();
		var duration = $("select[name='duration']").val();
		var is_edit = $("input[name='is_edit']").val();
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
				alert(response.message);
				refreshDatatable();
			},
			error: function(message){
				console.log(message.responseText);
				var errors = jQuery.parseJSON(message.responseText);
				var error = "";
				$.each(errors['errors'], function(a,b){
					error += b[0] + "\n";
				});
				alert(error);
			}
		});
	});

	/* Load Default Booking List */
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
		refreshDatatable();
	});

	/* Fetch Booking Info */
	$(document).on("click", ".editBooking", function(){
		var $elem = $(this);
		var booking_id = $elem.attr('booking-id-attrib');

		/* Set Booking ID to be Updated */
		$("input[name='is_edit']").val(booking_id);
		$("#checkAvailabilityBtn").text("Update Booking ID ("+ booking_id +")");
		$("#checkAvailabilityBtn").removeClass("btn-primary").addClass("btn-danger");

		/* Fetch Selected Booking Info */
		$.ajax({
			type: "GET",
			url: base_url + '/booking/fetch/',
			dataType:"json",
			data: {
				'booking_id': booking_id,
				"_token": csrf_token,
			},
			success: function(response){
				console.log(response.start_date);
				if(response)
				{
					$("input[name='start_date']").val(response.start_date);
					$("select[name='room']").val(response.room_id).change();
					$("input[name='start_time']").val(response.start_time);
					$("select[name='duration']").val(response.duration);
				}
			},
			error: function(message){
				console.log(message.responseText);
			}
		});
	});

	/* Reset Filters */
	$(document).on("click", "#clearFilter", function(){
		$("select[name='room']").val($("select[name='room'] option:first").val()).change();
		$("select[name='duration']").val($("select[name='duration'] option:first").val()).change();
		$("#checkAvailabilityBtn").removeClass("btn-danger").addClass("btn-primary");
		$("#checkAvailabilityBtn").text("Save Booking");
		$("input[type='date']").val("");
		$("input[type='time']").val("");
		$("input[name='is_edit']").val("");
		refreshDatatable();
	});


	/* Delete Booking */
	$(document).on("click", ".deleteBooking", function(){
		var $elem = $(this);
		var booking_id = $elem.attr('booking-id-attrib');
		var confirm_message = "Are you sure you want to delete Booking? " + booking_id;

		if (confirm(confirm_message) == true) {
			/* Delete Selected Booking */
			$.ajax({
				type: "DELETE",
				url: base_url + '/booking/',
				dataType:"json",
				data: {
					'booking_id': booking_id,
					"_token": csrf_token,
				},
				success: function(response){
					refreshDatatable();
					$("#clearFilter").trigger("click");
				},
				error: function(message){
					console.log(message.responseText);
				}
			});
		} 
	});

	function refreshDatatable()
	{
		$('.yajra-datatable').DataTable().ajax.reload();
	}

});