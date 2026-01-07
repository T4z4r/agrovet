@extends('layouts.master')

@section('title', 'Receipt')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <h4>Receipt</h4>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 60px;">
                    <h5>Agrovet</h5>
                    <p>Quality Agricultural Products</p>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong>Sale #:</strong> {{ $sale->id }}<br>
                        <strong>Date:</strong> {{ $sale->sale_date->format('d/m/Y') }}<br>
                        <strong>Time:</strong> {{ $sale->created_at->format('H:i:s') }}
                    </div>
                    <div class="col-6 text-end">
                        <strong>Seller:</strong> {{ $sale->seller->name }}<br>
                        @if($sale->customer_name)
                        <strong>Customer:</strong> {{ $sale->customer_name }}<br>
                        @endif
                        @if($sale->payment_method)
                        <strong>Payment:</strong> {{ ucfirst($sale->payment_method) }}
                        @endif
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }} KES</td>
                            <td>{{ number_format($item->total, 2) }} KES</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end">
                    <h4>Grand Total: {{ number_format($sale->total, 2) }} KES</h4>
                </div>

                <div class="text-center mt-4">
                    <p>Thank you for your business!</p>
                    <a href="{{ route('web.pos.index') }}" class="btn btn-primary">New Sale</a>
                    <button onclick="window.print()" class="btn btn-secondary">Print Receipt</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
