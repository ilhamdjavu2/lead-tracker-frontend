@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Lead Tracker</h3>
   <button onclick='showleadform()' data-bs-toggle="modal" data-bs-target="#loadmodal" data-bs-keyboard="false" data-bs-backdrop="static" class="btn btn-sm btn-pill btn-primary"> Add</button>
</div>

<table class="table table-bordered" id="leadTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Created Date</th>
            <th width="150">Action</th>
        </tr>
		<tr>
            <th><input type="text" placeholder="Search name" class="form-control"></th>
            <th><input type="text" placeholder="Search email" class="form-control"></th>
            <th><input type="text" placeholder="Search phone" class="form-control"></th>
            <th>
				<select id="statusFilter" class="form-control">
					<option value="">All Status</option>
					<option value="new">New</option>
					<option value="contacted">Contacted</option>
					<option value="qualified">Qualified</option>
					<option value="lost">Lost</option>
				</select>
			</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
</table>

@endsection

@push('scripts')

<script>
	var table = $('#leadTable').DataTable({
		processing: true,
		serverSide: true,
		ordering: false,

		ajax: {
			url: "/leads/datatable",
			type: "GET",
			dataSrc: function (json) {
				json.recordsTotal = json.result.recordsTotal;
				json.recordsFiltered = json.result.recordsFiltered;
				return json.result.data;
			}
		},

		columns: [
			{ data: 'name' },
			{ data: 'email' },
			{ data: 'phone' },
			{
				data: 'status',
				render: function (data, type, row) {
					return `
						<select class="form-control form-control-sm status-dropdown" data-id="${row.id}">
							<option value="new" ${data === 'new' ? 'selected' : ''}>New</option>
							<option value="contacted" ${data === 'contacted' ? 'selected' : ''}>Contacted</option>
							<option value="qualified" ${data === 'qualified' ? 'selected' : ''}>Qualified</option>
							<option value="lost" ${data === 'lost' ? 'selected' : ''}>Lost</option>
						</select>
					`;
				}
			},
			{ data: 'created_at', searchable: false },
			{
				data: 'id',
				render: function (data) {
					return `
						<button class="btn btn-danger btn-sm" onclick="confirmDelete(${data})">Delete</button>
					`;
				}
			}
		]
	});

	$('#leadTable thead tr:eq(1) th input').on('keyup change', function () {
		let colIndex = $(this).parent().index();
		table.column(colIndex).search(this.value).draw();
	});

	$('#statusFilter').on('change', function () {
		table.column(3).search(this.value).draw();
	});

	function showleadform() {
        $('#loadmodal').find('.modal-header .modal-title').html('<h3>Add Lead</h3>');

        $.ajax({
			url: "/leads/form",
            type: "GET",
            dataType: "html",
            data: {
				_token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $("#loadmodalloader").html('Loading...');
                $("#loadmodalcontent").html('');
            },
            success: function(data) {
                $("#loadmodalcontent").html(data);
            },
            complete: function() {
                $("#loadmodalcontent").show();
                $("#loadmodalloader").html('');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                $("#loadmodalcontent").html('<div class="alert alert-danger inverse alert-dismissible fade show m-0" role="alert"><i class="icofont icofont-warning-alt"></i> ' + pesan + '</div>');
            },
        });
    }
	
	function confirmDelete(id) {
		Swal.fire({
			title: "Are you sure?",
			text: "This lead will be deleted!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			confirmButtonText: "Yes, delete it!",
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false
		}).then((result) => {
			if (result.isConfirmed) {

				$.ajax({
					url: `/leads/delete/${id}`,
					type: "DELETE",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (res) {
						Swal.fire(
							"Deleted!",
							"Lead has been deleted.",
							"success"
						);

						$('#leadTable').DataTable().ajax.reload();
					},
					error: function () {
						Swal.fire(
							"Error!",
							"Something went wrong.",
							"error"
						);
					}
				});

			}
		});
	}
	
	$(document).on('change', '.status-dropdown', function () {
		let id = $(this).data('id');
		let status = $(this).val();

		Swal.fire({
			title: "Update Status?",
			text: `Change status to ${status}?`,
			icon: "question",
			showCancelButton: true,
			confirmButtonText: "Yes, update",
			cancelButtonText: "Cancel",
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false
		}).then((result) => {
			if (result.isConfirmed) {

				$.ajax({
					url: `/leads/${id}`,
					type: "PATCH",
					data: {
						status: status,
						_token: $('meta[name="csrf-token"]').attr('content')
					},
					success: function () {
						Swal.fire("Updated!", "Status updated successfully", "success");
						$('#leadTable').DataTable().ajax.reload(null, false);
					},
					error: function () {
						Swal.fire("Error!", "Failed to update status", "error");
					}
				});

			} else {
				$('#leadTable').DataTable().ajax.reload(null, false);
			}
		});
	});
</script>

@endpush