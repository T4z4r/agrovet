@extends('layouts.master')

@section('title', 'Products')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Products</h5>
                <a href="{{ route('web.products.create') }}" class="btn btn-primary">Add Product</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
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
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->unit }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->cost_price }}</td>
                                <td>{{ $product->selling_price }}</td>
                                <td>
                                    <a href="{{ route('web.products.show', $product) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('web.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('web.products.destroy', $product) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
