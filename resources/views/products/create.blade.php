@extends('layouts.master')

@section('title', 'Create Product')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create Product</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('web.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="common_product_id" class="form-label">Select Common Product (Optional)</label>
                            <select class="form-control" id="common_product_id" name="common_product_id">
                                <option value="">None - Create Custom Product</option>
                                @foreach($commonProducts as $commonProduct)
                                    <option value="{{ $commonProduct->id }}">{{ $commonProduct->name }} ({{ $commonProduct->commonCategory->name ?? 'No Category' }})</option>
                                @endforeach
                            </select>
                            @error('common_product_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}" required>
                            @error('category')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit') }}" required>
                            @error('unit')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" required min="0">
                            @error('stock')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="minimum_quantity" class="form-label">Minimum Quantity</label>
                            <input type="number" class="form-control" id="minimum_quantity" name="minimum_quantity" value="{{ old('minimum_quantity') }}" min="0">
                            @error('minimum_quantity')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cost_price" class="form-label">Cost Price</label>
                            <input type="number" class="form-control" id="cost_price" name="cost_price" value="{{ old('cost_price') }}" required min="0" step="0.01">
                            @error('cost_price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="selling_price" class="form-label">Selling Price</label>
                            <input type="number" class="form-control" id="selling_price" name="selling_price" value="{{ old('selling_price') }}" required min="0" step="0.01">
                            @error('selling_price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="barcode" class="form-label">Barcode</label>
                            <input type="text" class="form-control" id="barcode" name="barcode" value="{{ old('barcode') }}">
                            @error('barcode')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('web.products.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#common_product_id').change(function() {
        var commonProductId = $(this).val();
        if (commonProductId) {
            $.ajax({
                url: '{{ route("web.products.getCommonProduct") }}',
                type: 'GET',
                data: { id: commonProductId },
                success: function(data) {
                    $('#name').val(data.name);
                    $('#unit').val(data.unit);
                    $('#category').val(data.category);
                    $('#cost_price').val(data.cost_price);
                    $('#selling_price').val(data.selling_price);
                    $('#minimum_quantity').val(data.minimum_quantity);
                    $('#barcode').val(data.barcode);
                },
                error: function() {
                    alert('Error fetching common product data.');
                }
            });
        } else {
            // Clear fields if "None" selected
            $('#name').val('');
            $('#unit').val('');
            $('#category').val('');
            $('#cost_price').val('');
            $('#selling_price').val('');
            $('#minimum_quantity').val('');
            $('#barcode').val('');
        }
    });
});
</script>
@endsection
