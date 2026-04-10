<form method="post" id="lead-form" class="needs-validation invalid was-validated">
	@csrf
	
	<div id="showerror"></div>
	
	<div class="row">
		<div class="col-xl-4 col-md-12">
			<label class="form-label" for="name">Name</label>
			<input name="name" id="name" type="text" class="form-control" placeholder="Name" required>
		</div>
	
		<div class="col-xl-4 col-md-12">
			<label class="form-label" for="email">Email</label>
			<input name="email" id="email" type="text" class="form-control" placeholder="Email" required>
		</div>
		
		<div class="col-xl-4 col-md-12">
			<label class="form-label" for="phone">Phone</label>
			<input name="phone" id="phone" type="number" class="form-control" placeholder="Phone">
		</div>
	</div>
	<div class="row">
		<div class="col-xl-4 col-md-12">
			<label class="form-label" for="budget">Budget</label>
			<input name="budget" id="budget" type="number" step="0.01" class="form-control">
		</div>
		<div class="col-xl-8 col-md-12">
			<label class="form-label" for="notes">Notes</label>
			<textarea name="notes" id="notes" class="form-control" placeholder="Notes" rows="4"></textarea>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-md-12 text-end mt-4">
			<button type="submit" class="btn btn-sm btn-pill btn-primary"><i data-feather='save'></i> Save</button>
		</div>
	</div>
</form>

<script>
$('#lead-form').on('submit', function (event) {
		event.preventDefault();
		var data = new FormData($("#" + $(this).attr('id'))[0]);
		
		$.ajax({
			type: "POST",
			url: "/leads",
			processData: false,
			contentType: false,
			dataType: "json",
			data: data,
			beforeSend: function () {
				$("#showerror").html('');
				$("#loadmodalloader").html('Processing..');
				$("#loadmodalcontent").hide();
			},
			success: function (data) {
				if (data.success) {
					$('#loadmodal').modal('hide');

					Swal.fire({
						text: data.message,
						icon: "success"
					});

					$('#leadTable').DataTable().ajax.reload();
				}else {	
					$("#showerror").html('<div class="alert alert-danger dark" role="alert">Please fix the following errors <p>' + data.error + '</p></div>');
				}
			},
			complete: function () {
				$("#loadmodalloader").html('');
				$("#loadmodalcontent").show();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var message = xhr.status + " " + thrownError + "\n" + xhr.responseText;
				$("#showerror").html('<div class="alert alert-danger dark p-1" role="alert"><p>' + message + '</p></div>');
			},
		});
	});
</script>