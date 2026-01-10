@extends('layouts.master')

@section('title', 'Subscription Packages')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Subscription Packages</h5>
                <a href="{{ route('admin.subscription-packages.create') }}" class="btn btn-primary">Add Package</a>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Duration (Months)</th>
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
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.dt-column-search').DataTable({
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
                        <a href="{{ url('admin/subscription-packages') }}/${data}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ url('admin/subscription-packages') }}/${data}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    `;
                }
            }
        ],
        orderCellsTop: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
    });
});
</script>
@endsection