@extends('layouts.master')

@section('title', 'Subscription Packages')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Subscription Packages</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add Package</button>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Duration (Months)</th>
                            <th>Features</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Duration (Months)</th>
                            <th>Features</th>
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
                <h5 class="modal-title" id="createModalLabel">Add Subscription Package</h5>
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
                    <div class="mb-3">
                        <label for="create_price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="create_price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_duration_months" class="form-label">Duration (Months)</label>
                        <input type="number" class="form-control" id="create_duration_months" name="duration_months" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_feature_ids" class="form-label">Features</label>
                        <select class="form-control select" id="create_feature_ids" name="feature_ids[]" multiple>
                            @foreach($features ?? [] as $feature)
                                <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" class="form-check-input" id="create_is_active" name="is_active" value="1" checked>
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
                <h5 class="modal-title" id="editModalLabel">Edit Subscription Package</h5>
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
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="edit_price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_duration_months" class="form-label">Duration (Months)</label>
                        <input type="number" class="form-control" id="edit_duration_months" name="duration_months" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_feature_ids" class="form-label">Features</label>
                        <select class="form-control select" id="edit_feature_ids" name="feature_ids[]" multiple>
                            @foreach($features ?? [] as $feature)
                                <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active" value="1">
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
    function initSelect2(modalId, selectId) {
        $(selectId).select2({
            placeholder: "Select features",
            allowClear: true,
            width: '100%',
            dropdownParent: $(modalId)
        });
    }

    // INIT ONCE WHEN MODAL OPENS
    $('#createModal').on('shown.bs.modal', function () {
        initSelect2('#createModal', '#create_feature_ids');
    });


    // OPTIONAL: DESTROY ON CLOSE (prevents duplicates)
    $('#createModal').on('hidden.bs.modal', function () {
        $('#create_feature_ids').select2('destroy');
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#edit_feature_ids').select2('destroy');
    });

    var table = $('.dt-column-search').DataTable({
        ajax: {
            url: '{{ route("admin.subscription-packages.index") }}',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'name' },
            { data: 'description' },
            { data: 'price' },
            { data: 'duration_months' },
            {
                data: 'features',
                render: function(data) {
                    return data && data.length > 0 ? data.map(f => f.name).join(', ') : '';
                }
            },
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
                        <a href="{{ url('admin/subscription-packages') }}/${data}" class="btn btn-sm btn-info">View</a>
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
            url: '{{ route("admin.subscription-packages.store") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#createModal').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                    $('#createForm')[0].reset();
                    $('#create_feature_ids').val(null).trigger('change');
                }
            },
            error: function(xhr) {
                // Handle validation errors
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
            url: '{{ url("admin/subscription-packages") }}/' + id + '/edit',
            type: 'GET',
            success: function(data) {
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_description').val(data.description);
                $('#edit_price').val(data.price);
                $('#edit_duration_months').val(data.duration_months);
                // Clear previous selections
                $('#edit_feature_ids option').prop('selected', false);
                // Select current features
                if (data.features && data.features.length > 0) {
                    data.features.forEach(function(feature) {
                        $('#edit_feature_ids option[value="' + feature.id + '"]').prop('selected', true);
                    });
                }
                $('#edit_feature_ids').trigger('change');
                $('#edit_is_active').prop('checked', data.is_active);
                initSelect2('#editModal', '#edit_feature_ids');
                $('#editModal').modal('show');
            }
        });
    });

    // Edit form submit
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_id').val();
        $.ajax({
            url: '{{ url("admin/subscription-packages") }}/' + id,
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
        if (confirm('Are you sure you want to delete this package?')) {
            $.ajax({
                url: '{{ url("admin/subscription-packages") }}/' + id,
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

