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
                    <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#commonProductsModal">Add from Common Products</button>
                    <a href="{{ route('web.products.create') }}" class="btn btn-primary">Add Product</a>
                </div>
            </div>
            <div class="card-body pb-0">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
var isOwner = {{ Auth::user()->hasRole('owner') ? 'true' : 'false' }};
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
                    let buttons = `
                        <a href="{{ url('products') }}/${data}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ url('products') }}/${data}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ url('products') }}/${data}" class="d-inline" id="delete-form-${data}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(${data})">Delete</button>
                        </form>
                    `;
                    if (isOwner) {
                        buttons += `
                            <form method="POST" action="{{ url('products') }}/${data}" class="d-inline" id="force-delete-form-${data}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="force" value="1">
                                <button type="button" class="btn btn-sm btn-dark" onclick="confirmForceDelete(${data})">Force Delete</button>
                            </form>
                        `;
                    }
                    return buttons;
                }
            }
        ],
        orderCellsTop: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
    });
});

function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d6d6d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

function confirmForceDelete(id) {
    Swal.fire({
        title: 'Force Delete Product?',
        text: "This product has sales or stock transactions. Deleting it may affect data integrity. Are you sure?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, force delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('force-delete-form-' + id).submit();
        }
    });
}
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
                        <div class="form-text">
                            Upload a file with product data. Make sure to use the correct format.
                            <a href="{{ route('web.products.downloadTemplate') }}" class="text-primary">Download Template</a>
                        </div>
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

<!-- Common Products Modal -->
<div class="modal fade" id="commonProductsModal" tabindex="-1" aria-labelledby="commonProductsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commonProductsModalLabel">Add from Common Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('web.products.addFromCommon') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="commonProductSearch" placeholder="Search common products...">
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead class="sticky-top bg-white">
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" id="selectAllCommon" class="form-check-input">
                                    </th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Unit</th>
                                    <th>Cost Price</th>
                                    <th>Selling Price</th>
                                </tr>
                            </thead>
                            <tbody id="commonProductsList">
                                <tr>
                                    <td colspan="6" class="text-center">Loading...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2 text-muted small">
                        <span id="selectedCount">0</span> product(s) selected. Products will be added with 0 initial stock.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning" id="addCommonBtn" disabled>Add Selected Products</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load common products when modal opens
    $('#commonProductsModal').on('show.bs.modal', function() {
        $.ajax({
            url: '{{ route("web.products.commonProductsList") }}',
            type: 'GET',
            success: function(data) {
                var html = '';
                if (data.length === 0) {
                    html = '<tr><td colspan="6" class="text-center">No common products available.</td></tr>';
                } else {
                    data.forEach(function(product) {
                        html += '<tr class="common-product-row">';
                        html += '<td><input type="checkbox" class="form-check-input common-product-checkbox" name="common_product_ids[]" value="' + product.id + '"></td>';
                        html += '<td>' + product.name + '</td>';
                        html += '<td>' + (product.category_name || '-') + '</td>';
                        html += '<td>' + (product.unit || '-') + '</td>';
                        html += '<td>' + (product.default_cost_price || 0) + '</td>';
                        html += '<td>' + (product.default_selling_price || 0) + '</td>';
                        html += '</tr>';
                    });
                }
                $('#commonProductsList').html(html);
            },
            error: function() {
                $('#commonProductsList').html('<tr><td colspan="6" class="text-center text-danger">Error loading common products.</td></tr>');
            }
        });
    });

    // Select all checkbox
    $(document).on('change', '#selectAllCommon', function() {
        $('.common-product-checkbox:visible').prop('checked', this.checked);
        updateSelectedCount();
    });

    // Individual checkbox change
    $(document).on('change', '.common-product-checkbox', function() {
        updateSelectedCount();
    });

    // Search filter
    $('#commonProductSearch').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.common-product-row').each(function() {
            var text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(value) > -1);
        });
    });

    function updateSelectedCount() {
        var count = $('.common-product-checkbox:checked').length;
        $('#selectedCount').text(count);
        $('#addCommonBtn').prop('disabled', count === 0);
    }
});
</script>
@endsection
