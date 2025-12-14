@extends('layouts.master')

@section('title', 'Stock Transactions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Stock Transactions</h5>
                <a href="{{ route('web.stock-transactions.create') }}" class="btn btn-primary">Add Transaction</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Supplier</th>
                                <th>Date</th>
                                <th>Recorded By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->product->name }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ $transaction->quantity }}</td>
                                <td>{{ $transaction->supplier ? $transaction->supplier->name : 'N/A' }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->user->name }}</td>
                                <td>
                                    <a href="{{ route('web.stock-transactions.show', $transaction) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('web.stock-transactions.edit', $transaction) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('web.stock-transactions.destroy', $transaction) }}" class="d-inline">
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