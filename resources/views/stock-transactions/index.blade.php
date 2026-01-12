@extends('layouts.master')

@section('title', 'Stock Transactions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Stock Transactions</h5>
                <a href="{{ route('web.stock-transactions.create') }}" class="btn btn-primary">Add Transaction</a>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Recorded By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Recorded By</th>
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
            url: '{{ route("web.stock-transactions.index") }}',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'product.name' },
            { data: 'type', render: function(data) { return data.charAt(0).toUpperCase() + data.slice(1); } },
            { data: 'quantity' },
            { data: 'supplier', render: function(data) { return data ? data.name : 'N/A'; } },
            { data: 'date' },
            { data: 'user.name' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <a href="{{ url('stock-transactions') }}/${data}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ url('stock-transactions') }}/${data}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ url('stock-transactions') }}/${data}" class="d-inline">
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