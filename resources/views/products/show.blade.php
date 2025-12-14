@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<h1>{{ $product->name }}</h1>
<p><strong>Category:</strong> {{ $product->category }}</p>
<p><strong>Unit:</strong> {{ $product->unit }}</p>
<p><strong>Stock:</strong> {{ $product->stock }}</p>
<p><strong>Cost Price:</strong> {{ $product->cost_price }}</p>
<p><strong>Selling Price:</strong> {{ $product->selling_price }}</p>
<a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
<a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
@endsection