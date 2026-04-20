@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Welcome to Apex! 🎉</h5>
                        <p class="mb-4">
                            You have logged in successfully. Manage your products, suppliers, sales, and more.
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img
                            src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                            height="140"
                            alt="View Badge User"
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
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="bx bx-package bx-lg mb-2"></i>
                <h5 class="text-white">Total Products</h5>
                <h3 class="text-white"> {{ $data['total_products'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="bx bx-money bx-lg mb-2"></i>
                <h5 class="text-white">Total Sales</h5>
                <h3 class="text-white">{{ number_format($data['total_sales'], 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <i class="bx bx-trending-down bx-lg mb-2"></i>
                <h5 class="text-white">Total Expenses</h5>
                <h3 class="text-white">{{ number_format($data['total_expenses'], 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="bx bx-calendar bx-lg mb-2"></i>
                <h5 class="text-white">Today Sales</h5>
                <h3 class="text-white">{{ number_format($data['today_sales'], 2) }}</h3>
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
                <h4 class="text-primary">
                    <span class="value-hidden">****</span>
                    <span class="value-visible" style="display: none;">{{ number_format($data['stock_value'], 2) }}</span>
                </h4>
                <p>Total value of current stock based on cost prices.</p>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="toggleValue(this)">Show</button>
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
                    <span class="value-hidden">****</span>
                    <span class="value-visible" style="display: none;">{{ number_format($data['total_sales'] - $data['total_expenses'], 2) }}</span>
                </h4>
                <p>Total sales minus total expenses.</p>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="toggleValue(this)">Show</button>
            </div>
        </div>
    </div>
</div>

<script>
function toggleValue(btn) {
    const parent = btn.parentElement;
    const hidden = parent.querySelector('.value-hidden');
    const visible = parent.querySelector('.value-visible');
    if (hidden.style.display !== 'none') {
        hidden.style.display = 'none';
        visible.style.display = 'inline';
        btn.textContent = 'Hide';
    } else {
        hidden.style.display = 'inline';
        visible.style.display = 'none';
        btn.textContent = 'Show';
    }
}
</script>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6>Sales and Expenses Over Last 30 Days</h6>
            </div>
            <div class="card-body">
                <div id="chart-container" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var salesData    = @json(array_values($salesData));
        var expensesData = @json(array_values($expensesData));
        var dates        = @json(array_values($dates));

        // Ensure all values are numbers
        salesData    = salesData.map(function (v) { return parseFloat(v) || 0; });
        expensesData = expensesData.map(function (v) { return parseFloat(v) || 0; });

        Highcharts.chart('chart-container', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent'
            },
            title: {
                text: 'Sales vs Expenses — Last 30 Days'
            },
            xAxis: {
                categories: dates,
                crosshair: true,
                labels: { rotation: -45, style: { fontSize: '11px' } }
            },
            yAxis: {
                min: 0,
                title: { text: 'Amount (TZS)' },
                gridLineColor: '#e0e0e0'
            },
            legend: { enabled: true },
            tooltip: {
                shared: true,
                formatter: function () {
                    var s = '<b>' + this.x + '</b>';
                    this.points.forEach(function (p) {
                        s += '<br/>' + p.series.name + ': TZS ' +
                            Highcharts.numberFormat(p.y, 2, '.', ',');
                    });
                    return s;
                }
            },
            plotOptions: {
                column: {
                    grouping: true,
                    pointPadding: 0.05,
                    groupPadding: 0.1,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Sales',
                data: salesData,
                color: '#28a745'
            }, {
                name: 'Expenses',
                data: expensesData,
                color: '#dc3545'
            }]
        });
    });
</script>
@endsection
