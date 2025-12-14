@extends('layouts.master')

@section('title', 'Create Sale')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create Sale</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('web.sales.store') }}" id="saleForm">
                    @csrf
                    <div class="mb-3">
                        <label for="sale_date" class="form-label">Sale Date</label>
                        <input type="date" class="form-control" id="sale_date" name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required>
                        @error('sale_date')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <h6>Items</h6>
                    <div id="items">
                        <div class="item-row row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Product</label>
                                <select class="form-control product-select" name="items[0][product_id]" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-stock="{{ $product->stock }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control quantity-input" name="items[0][quantity]" min="1" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control price-input" name="items[0][price]" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-danger remove-item">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="addItem">Add Item</button>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Create Sale</button>
                        <a href="{{ route('web.sales.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    document.getElementById('addItem').addEventListener('click', function() {
        const itemsDiv = document.getElementById('items');
        const newRow = document.createElement('div');
        newRow.className = 'item-row row mb-3';
        newRow.innerHTML = `
            <div class="col-md-4">
                <label class="form-label">Product</label>
                <select class="form-control product-select" name="items[${itemIndex}][product_id]" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-stock="{{ $product->stock }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control quantity-input" name="items[${itemIndex}][quantity]" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control price-input" name="items[${itemIndex}][price]" min="0" step="0.01" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger remove-item">Remove</button>
            </div>
        `;
        itemsDiv.appendChild(newRow);
        itemIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
        }
    });
});
</script>
@endsection
