@extends('layouts.master')

@section('title', 'Guides Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Guides Management</h5>
                <a href="{{ route('admin.guides.create') }}" class="btn btn-primary">Add Guide</a>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Language</th>
                            <th>Target Role</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Title</th>
                            <th>Language</th>
                            <th>Target Role</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Guide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this guide? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    var table = $('.dt-column-search').DataTable({
        ajax: {
            url: '{{ route("admin.guides.index") }}',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'title' },
            {
                data: 'language',
                render: function(data) {
                    return data === 'en' ? 'English' : 'Swahili';
                }
            },
            {
                data: 'target_role',
                render: function(data) {
                    switch(data) {
                        case 'owner': return 'Owner';
                        case 'seller': return 'Seller';
                        case 'both': return 'Both';
                        default: return data;
                    }
                }
            },
            { data: 'creator.name' },
            { data: 'created_at' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var actions = `
                        <a href="{{ url('admin/guides') }}/${data}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ url('admin/guides') }}/${data}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="${data}">Delete</button>
                    `;

                    if (row.file_path) {
                        actions += `<a href="{{ url('admin/guides') }}/${data}/download" class="btn btn-sm btn-success">Download</a>`;
                    }

                    return actions;
                }
            }
        ],
        orderCellsTop: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
    });

    // Delete button click
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        $('#confirmDelete').data('id', id);
        $('#deleteModal').modal('show');
    });

    // Confirm delete
    $('#confirmDelete').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ url("admin/guides") }}/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#deleteModal').modal('hide');
                    table.ajax.reload();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('An error occurred while deleting the guide.');
            }
        });
    });
});
</script>
@endsection
