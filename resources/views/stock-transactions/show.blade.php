@extends('layouts.master')

@section('title', 'Stock Transaction Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Stock Transaction Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Product:</strong> {{ $transaction->product->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Type:</strong> {{ ucfirst($transaction->type) }}
                    </div>
                    <div class="col-md-6">
                        <strong>Quantity:</strong> {{ $transaction->quantity }}
                    </div>
                    <div class="col-md-6">
                        <strong>Supplier:</strong> {{ $transaction->supplier ? $transaction->supplier->name : 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Date:</strong> {{ $transaction->date }}
                    </div>
                    <div class="col-md-6">
                        <strong>Recorded By:</strong> {{ $transaction->user->name }}
                    </div>
                    <div class="col-12">
                        <strong>Remarks:</strong> {{ $transaction->remarks ?: 'N/A' }}
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('web.stock-transactions.edit', $transaction) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('web.stock-transactions.index') }}" class="btn btn-secondary">Back to Transactions</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection