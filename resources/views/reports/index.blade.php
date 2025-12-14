@extends('layouts.master')

@section('title', 'Reports')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Reports</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="bx bx-calendar bx-lg text-primary mb-3"></i>
                                <h5>Daily Report</h5>
                                <p>Get sales and expenses for a specific date.</p>
                                <form method="GET" action="{{ route('web.reports.daily') }}">
                                    <div class="mb-3">
                                        <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Generate</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="bx bx-trending-up bx-lg text-success mb-3"></i>
                                <h5>Profit Report</h5>
                                <p>View profit between two dates.</p>
                                <form method="GET" action="{{ route('web.reports.profit') }}">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" class="form-control" name="start" value="{{ date('Y-m-d', strtotime('-30 days')) }}" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" class="form-control" name="end" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Generate</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="bx bx-dashboard bx-lg text-info mb-3"></i>
                                <h5>Dashboard Summary</h5>
                                <p>Overall statistics and summary.</p>
                                <a href="{{ route('web.reports.dashboard') }}" class="btn btn-info">View Dashboard</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="bx bx-user bx-lg text-warning mb-3"></i>
                                <h5>Seller Day Summary</h5>
                                <p>Your daily activity summary.</p>
                                <form method="GET" action="{{ route('web.reports.seller.day-summary') }}">
                                    <div class="mb-3">
                                        <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-warning">Generate</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection