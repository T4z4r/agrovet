@extends('layouts.master')

@section('title', 'Supplier Details')

@section('content')
<h1>{{ $supplier->name }}</h1>
<p><strong>Phone:</strong> {{ $supplier->phone }}</p>
<p><strong>Email:</strong> {{ $supplier->email }}</p>
<p><strong>Address:</strong> {{ $supplier->address }}</p>
<a href="{{ route('web.suppliers.index') }}" class="btn btn-secondary">Back</a>
<a href="{{ route('web.suppliers.edit', $supplier) }}" class="btn btn-warning">Edit</a>
@endsection
