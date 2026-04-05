@extends('layouts.master')

@section('title', 'Edit Common Product')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Common Product</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('web.superadmin.common-products.update', $commonProduct) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $commonProduct->name }}" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="common_category_id" class="form-label">Category</label>
                            <select class="form-control" id="common_category_id" name="common_category_id" required>
                                <option value="">Select Category</option>
                                @foreach($commonCategories as $category)
                                    <option value="{{ $category->id }}" {{ $commonProduct->common_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('common_category_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control" id="unit" name="unit" value="{{ $commonProduct->unit }}" required>
                            @error('unit')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="default_cost_price" class="form-label">Default Cost Price</label>
                            <input type="number" class="form-control" id="default_cost_price" name="default_cost_price" value="{{ $commonProduct->default_cost_price }}" required min="0" step="0.01">
                            @error('default_cost_price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="default_selling_price" class="form-label">Default Selling Price</label>
                            <input type="number" class="form-control" id="default_selling_price" name="default_selling_price" value="{{ $commonProduct->default_selling_price }}" required min="0" step="0.01">
                            @error('default_selling_price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="default_minimum_quantity" class="form-label">Default Minimum Quantity</label>
                            <input type="number" class="form-control" id="default_minimum_quantity" name="default_minimum_quantity" value="{{ $commonProduct->default_minimum_quantity }}" min="0">
                            @error('default_minimum_quantity')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="barcode" class="form-label">Barcode</label>
                            <input type="text" class="form-control" id="barcode" name="barcode" value="{{ $commonProduct->barcode }}">
                            @error('barcode')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            @if($commonProduct->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $commonProduct->photo) }}" alt="Current Photo" style="max-width: 200px; max-height: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $commonProduct->description }}</textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $commonProduct->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                            @error('is_active')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('web.superadmin.common-products.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection