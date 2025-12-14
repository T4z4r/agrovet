@extends('layouts.master')

@section('title', 'Dashboard Summary')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Dashboard Summary</h5>
                <a href="{{ route('web.reports.index') }}" class="btn btn-secondary">Back to Reports</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <i class="bx bx-package bx-lg mb-2"></i>
                                <h5>Total Products</h5>
                                <h3>{{ $data['total_products'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <i class="bx bx-money bx-lg mb-2"></i>
                                <h5>Total Sales</h5>
                                <h3>{{ $data['total_sales'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <i class="bx bx-trending-down bx-lg mb-2"></i>
                                <h5>Total Expenses</h5>
                                <h3>{{ $data['total_expenses'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <i class="bx bx-calendar bx-lg mb-2"></i>
                                <h5>Today Sales</h5>
                                <h3>{{ $data['today_sales'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6>Stock Value</h6>
                            </div>
                            <div class="card-body">
                                <h4 class="text-primary">{{ $data['stock_value'] }}</h4>
                                <p>Total value of current stock based on cost prices.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6>Net Position</h6>
                            </div>
                            <div class="card-body">
                                <h4 class="{{ $data['total_sales'] - $data['total_expenses'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $data['total_sales'] - $data['total_expenses'] }}
                                </h4>
                                <p>Total sales minus total expenses.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection