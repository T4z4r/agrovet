@extends('layouts.master')

@section('title', 'Seller Day Summary - ' . $date)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Your Day Summary for {{ $date }}</h5>
                <a href="{{ route('web.reports.index') }}" class="btn btn-secondary">Back to Reports</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5>Total Sales: {{ $total_sales }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5>Total Expenses: {{ $total_expenses }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <h6>Sales</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Total</th>
                                <th>Items</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->total }}</td>
                                <td>{{ $sale->items->count() }} items</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No sales for this date</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <h6>Expenses</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Shop</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                            <tr>
                                <td>{{ $expense->category }}</td>
                                <td>{{ $expense->amount }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>{{ $expense->shop->name }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No expenses for this date</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <h6>Stock Transactions</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Supplier</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stock_transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->product->name }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ $transaction->quantity }}</td>
                                <td>{{ $transaction->supplier ? $transaction->supplier->name : 'N/A' }}</td>
                                <td>{{ $transaction->remarks ?: 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No stock transactions for this date</td>
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