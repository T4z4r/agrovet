@extends('layouts.master')

@section('title', 'Common Product Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $commonProduct->name }}</h5>
                <div>
                    <a href="{{ route('web.superadmin.common-products.index') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ route('web.superadmin.common-products.edit', $commonProduct) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $commonProduct->name }}</p>
                        <p><strong>Category:</strong> {{ $commonProduct->commonCategory->name }}</p>
                        <p><strong>Unit:</strong> {{ $commonProduct->unit }}</p>
                        <p><strong>Default Cost Price:</strong> {{ $commonProduct->default_cost_price }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Default Selling Price:</strong> {{ $commonProduct->default_selling_price }}</p>
                        <p><strong>Default Minimum Quantity:</strong> {{ $commonProduct->default_minimum_quantity ?: 'N/A' }}</p>
                        <p><strong>Barcode:</strong> {{ $commonProduct->barcode ?: 'N/A' }}</p>
                        <p><strong>Status:</strong> {{ $commonProduct->is_active ? 'Active' : 'Inactive' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Description:</strong> {{ $commonProduct->description ?: 'N/A' }}</p>
                    </div>
                </div>
                @if($commonProduct->photo)
                    <div class="row">
                        <div class="col-12">
                            <p><strong>Photo:</strong></p>
                            <img src="{{ asset('storage/' . $commonProduct->photo) }}" alt="Product Photo" style="max-width: 300px; max-height: 300px;">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Related Products</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Shop</th>
                                <th>Stock</th>
                                <th>Cost Price</th>
                                <th>Selling Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commonProduct->products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->shop->name }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->cost_price }}</td>
                                <td>{{ $product->selling_price }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No related products found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection