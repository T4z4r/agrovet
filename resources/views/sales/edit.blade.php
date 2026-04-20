@extends('layouts.master')

@section('title', 'Edit Sale')

@php
$productOptions = '';
foreach($products as $product) {
    $productOptions .= '<option value="' . $product->id . '" data-stock="' . $product->stock . '">' . $product->name . '</option>';
}
@endphp

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Sale #{{ $sale->id }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('web.sales.update', $sale) }}">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sale_date" class="form-label">Sale Date</label>
                            <input type="date" class="form-control" id="sale_date" name="sale_date" value="{{ old('sale_date', $sale->sale_date->format('Y-m-d')) }}" required>
                            @error('sale_date')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <input type="text" class="form-control" id="payment_method" name="payment_method" value="{{ old('payment_method', $sale->payment_method) }}" placeholder="e.g. cash, mpesa, card">
                            @error('payment_method')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name', $sale->customer_name) }}" placeholder="Enter customer name">
                        @error('customer_name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <h6>Items</h6>
                    <div id="items">
                        @foreach($sale->items as $index => $item)
                        <div class="item-row row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Product</label>
                                <select class="form-control product-select" name="items[{{ $index }}][product_id]" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" {{ $product->id == $item->product_id ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control quantity-input" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" min="1" placeholder="1" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control price-input" name="items[{{ $index }}][price]" value="{{ $item->price }}" min="0" step="0.01" placeholder="0.00" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-danger remove-item">Remove</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary" id="addItem">Add Item</button>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Sale</button>
                        <a href="{{ route('web.sales.show', $sale) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const productOptions = `{!! addslashes($productOptions) !!}`;

document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = {{ count($sale->items) }};

    document.getElementById('addItem').addEventListener('click', function() {
        const itemsDiv = document.getElementById('items');
        const newRow = document.createElement('div');
        newRow.className = 'item-row row mb-3';
        newRow.innerHTML = `
            <div class="col-md-4">
                <label class="form-label">Product</label>
                <select class="form-control product-select" name="items[${itemIndex}][product_id]" required>
                    <option value="">Select Product</option>
                    ${productOptions}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control quantity-input" name="items[${itemIndex}][quantity]" min="1" placeholder="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control price-input" name="items[${itemIndex}][price]" min="0" step="0.01" placeholder="0.00" required>
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