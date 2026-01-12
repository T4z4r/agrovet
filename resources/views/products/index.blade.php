@extends('layouts.master')

@section('title', 'Products')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Products</h5>
                <div>
                    <a href="{{ route('web.products.downloadTemplate') }}" class="btn btn-info me-2">Download Template</a>
                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">Import Products</button>
                    <a href="{{ route('web.products.create') }}" class="btn btn-primary">Add Product</a>
                </div>
            </div>
            <div class="card-datatable text-nowrap">
                <table class="dt-column-search table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Stock</th>
                            <th>Cost Price</th>
                            <th>Selling Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Stock</th>
                            <th>Cost Price</th>
                            <th>Selling Price</th>
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
            url: '{{ route("web.products.index") }}',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'name' },
            { data: 'category' },
            { data: 'unit' },
            { data: 'stock' },
            { data: 'cost_price' },
            { data: 'selling_price' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <a href="{{ url('products') }}/${data}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ url('products') }}/${data}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ url('products') }}/${data}" class="d-inline">
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

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('web.products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Select Excel/CSV File</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                        <div class="form-text">Upload a file with product data. Make sure to use the downloaded template format.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Import Products</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
