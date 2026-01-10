@extends('layouts.master')

@section('title', 'Subscriptions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Subscriptions</h5>
                <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">Add Subscription</a>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered">
                    <thead>
                        <tr>
                            <th>Shop</th>
                            <th>Package</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Shop</th>
                            <th>Package</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
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
            url: '{{ route("admin.subscriptions.index") }}',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'shop.name' },
            { data: 'subscription_package.name' },
            { data: 'start_date' },
            { data: 'end_date' },
            { data: 'status' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <a href="{{ url('admin/subscriptions') }}/${data}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ url('admin/subscriptions') }}/${data}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ url('admin/subscriptions') }}/${data}" class="d-inline">
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
