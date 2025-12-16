@extends('layouts.master')

@section('title', 'Product Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $product->name }}</h5>
                <div>
                    <a href="{{ route('web.products.index') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ route('web.products.edit', $product) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Category:</strong> {{ $product->category }}</p>
                        <p><strong>Unit:</strong> {{ $product->unit }}</p>
                        <p><strong>Stock:</strong> {{ $product->stock }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Cost Price:</strong> {{ $product->cost_price }}</p>
                        <p><strong>Selling Price:</strong> {{ $product->selling_price }}</p>
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
                <h5 class="mb-0">Stock Transactions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Supplier</th>
                                <th>Date</th>
                                <th>Recorded By</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product->stockTransactions as $transaction)
                            <tr>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ $transaction->quantity }}</td>
                                <td>{{ $transaction->supplier ? $transaction->supplier->name : 'N/A' }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ $transaction->remarks ?: 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No stock transactions found.</td>
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
