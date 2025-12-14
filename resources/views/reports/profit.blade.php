@extends('layouts.master')

@section('title', 'Profit Report - ' . $start . ' to ' . $end)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Profit Report from {{ $start }} to {{ $end }}</h5>
                <a href="{{ route('web.reports.index') }}" class="btn btn-secondary">Back to Reports</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h5>Total Revenue</h5>
                                <h3>{{ $total_revenue }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-secondary text-white">
                            <div class="card-body text-center">
                                <h5>Total Cost</h5>
                                <h3>{{ $total_cost }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card {{ $profit >= 0 ? 'bg-primary' : 'bg-secondary' }} text-white">
                            <div class="card-body text-center">
                                <h5>Profit</h5>
                                <h3>{{ $profit }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert {{ $profit >= 0 ? 'alert-success' : 'alert-danger' }}">
                    <strong>{{ $profit >= 0 ? 'Profit' : 'Loss' }}:</strong> {{ abs($profit) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection