@extends('layouts.master')

@section('title', 'Features')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Features</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add Feature</button>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add Feature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="create_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_description" class="form-label">Description</label>
                        <textarea class="form-control" id="create_description" name="description"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="create_is_active" name="is_active" checked>
                        <label class="form-check-label" for="create_is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Feature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active">
                        <label class="form-check-label" for="edit_is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    var table = $('.dt-column-search').DataTable({
        ajax: {
            url: '{{ route("admin.features.index") }}',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'name' },
            { data: 'description' },
            {
                data: 'is_active',
                render: function(data) {
                    return data ? 'Yes' : 'No';
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <a href="{{ url('admin/features') }}/${data}" class="btn btn-sm btn-info">View</a>
                        <button type="button" class="btn btn-sm btn-warning edit-btn" data-id="${data}">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="${data}">Delete</button>
                    `;
                }
            }
        ],
        orderCellsTop: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
    });

    // Create form submit
    $('#createForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admin.features.store") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#createModal').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                    $('#createForm')[0].reset();
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                for (var field in errors) {
                    alert(errors[field][0]);
                }
            }
        });
    });

    // Edit button click
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ url("admin/features") }}/' + id + '/edit',
            type: 'GET',
            success: function(data) {
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_description').val(data.description);
                $('#edit_is_active').prop('checked', data.is_active);
                $('#editModal').modal('show');
            }
        });
    });

    // Edit form submit
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_id').val();
        $.ajax({
            url: '{{ url("admin/features") }}/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editModal').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                for (var field in errors) {
                    toastr.error(errors[field][0]);
                }
            }
        });
    });

    // Delete button click
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this feature?')) {
            $.ajax({
                url: '{{ url("admin/features") }}/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        table.ajax.reload();
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
});
</script>
@endsection