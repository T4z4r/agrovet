@extends('layouts.master')

@section('title', 'Edit Product')

@section('content')
<h1>Edit Product</h1>
<form method="POST" action="{{ route('web.products.update', $product) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <input type="text" class="form-control" id="category" name="category" value="{{ $product->category }}" required>
        @error('category')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="unit" class="form-label">Unit</label>
        <input type="text" class="form-control" id="unit" name="unit" value="{{ $product->unit }}" required>
        @error('unit')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required min="0">
        @error('stock')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="cost_price" class="form-label">Cost Price</label>
        <input type="number" class="form-control" id="cost_price" name="cost_price" value="{{ $product->cost_price }}" required min="0">
        @error('cost_price')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="selling_price" class="form-label">Selling Price</label>
        <input type="number" class="form-control" id="selling_price" name="selling_price" value="{{ $product->selling_price }}" required min="0">
        @error('selling_price')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('web.products.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
