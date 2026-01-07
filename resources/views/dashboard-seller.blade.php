@extends('layouts.master')

@section('title', 'Seller Dashboard - ' . auth()->user()->name)

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Welcome back, {{ auth()->user()->name }}! 🎉</h5>
                        <p class="mb-4">
                            Here's your performance summary for today. Keep up the great work!
                        </p>
                        <a href="{{ route('web.pos.index') }}" class="btn btn-primary">Start Selling</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img
                            src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                            height="140"
                            alt="Seller Dashboard"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="bx bx-trending-up bx-lg mb-2"></i>
                <h5 class="text-white">Today's Sales</h5>
                <h3 class="text-white">{{ number_format($data['today_sales'], 2) }}</h3>
                <small>{{ $data['today_sales_count'] }} transactions</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="bx bx-money bx-lg mb-2"></i>
                <h5 class="text-white">Today's Expenses</h5>
                <h3 class="text-white">{{ number_format($data['today_expenses'], 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="bx bx-calendar bx-lg mb-2"></i>
                <h5 class="text-white">Monthly Sales</h5>
                <h3 class="text-white">{{ number_format($data['month_sales'], 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <i class="bx bx-package bx-lg mb-2"></i>
                <h5 class="text-white">Total Sales</h5>
                <h3 class="text-white">{{ number_format($data['total_sales_count']) }}</h3>
                <small>All time transactions</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6>Today's Net Performance</h6>
            </div>
            <div class="card-body">
                <h4 class="{{ $data['today_sales'] - $data['today_expenses'] >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($data['today_sales'] - $data['today_expenses'], 2) }}
                </h4>
                <p>Today's sales minus today's expenses.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6>Monthly Net Performance</h6>
            </div>
            <div class="card-body">
                <h4 class="{{ $data['month_sales'] - $data['month_expenses'] >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($data['month_sales'] - $data['month_expenses'], 2) }}
                </h4>
                <p>This month's sales minus expenses.</p>
            </div>
        </div>
    </div>
</div>

@if($recentSales->count() > 0)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6>Recent Sales Today</h6>
                <a href="{{ route('web.pos.index') }}" class="btn btn-sm btn-primary">Make New Sale</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSales as $sale)
                            <tr>
                                <td>{{ $sale->created_at->format('H:i') }}</td>
                                <td>{{ $sale->items->count() }} item(s)</td>
                                <td>{{ number_format($sale->total, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $sale->payment_method === 'cash' ? 'success' : 'info' }}">
                                        {{ ucfirst($sale->payment_method ?? 'N/A') }}
                                    </span>
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
@endif
@endsection