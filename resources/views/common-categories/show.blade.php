@extends('layouts.master')

@section('title', 'Common Category Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $commonCategory->name }}</h5>
                <div>
                    <a href="{{ route('web.superadmin.common-categories.index') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ route('web.superadmin.common-categories.edit', $commonCategory) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $commonCategory->name }}</p>
                        <p><strong>Description:</strong> {{ $commonCategory->description ?: 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> {{ $commonCategory->is_active ? 'Active' : 'Inactive' }}</p>
                        <p><strong>Created At:</strong> {{ $commonCategory->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Common Products</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Default Cost Price</th>
                                <th>Default Selling Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commonCategory->commonProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->unit }}</td>
                                <td>{{ $product->default_cost_price }}</td>
                                <td>{{ $product->default_selling_price }}</td>
                                <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No common products found.</td>
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