@extends('layouts.master')

@section('title', 'Receipt')

@section('content')
<div class="container-fluid" style="background-color: #f9f9f9; min-height: 100vh; padding: 20px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow" style="border: 1px solid #e0e0e0; border-radius: 8px;">
                <div class="card-body p-4">
                    <div class="header text-center" style="border-bottom: 3px solid #851b2d; padding-bottom: 15px; margin-bottom: 20px;">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Apex Logo" style="width: 120px; height: auto; margin-bottom: 10px;">
                        <h1 style="color: #851b2d; margin: 0; font-size: 28px; font-weight: bold;">Apex</h1>
                        <p style="margin: 5px 0; color: #666; font-size: 14px;">Quality and Affordable Products</p>
                        <p style="margin: 5px 0; color: #666; font-size: 14px;">Receipt</p>
                    </div>

                    <div class="receipt-info d-flex justify-content-between mb-4" style="background-color: #f1f8e9; padding: 10px; border-radius: 5px;">
                        <div>
                            <strong>Sale #:</strong> {{ $sale->id }}<br>
                            <strong>Date:</strong> {{ $sale->sale_date->format('d/m/Y') }}<br>
                            <strong>Seller:</strong> {{ $sale->seller->name }}
                        </div>
                        <div style="text-align: right;">
                            <strong>Time:</strong> {{ $sale->created_at->format('H:i:s') }}<br>
                            @if($sale->customer_name)
                            <strong>Customer:</strong> {{ $sale->customer_name }}<br>
                            @endif
                            @if($sale->payment_method)
                            <strong>Payment:</strong> {{ ucfirst($sale->payment_method) }}
                            @endif
                        </div>
                    </div>

                    <table class="table table-bordered" style="border: 1px solid #ddd; margin-bottom: 20px;">
                        <thead>
                            <tr style="background-color: #851b2d; color: #fff;">
                                <th style="border: 1px solid #ddd; padding: 10px; font-weight: bold; text-transform: uppercase; font-size: 12px;">Item</th>
                                <th style="border: 1px solid #ddd; padding: 10px; font-weight: bold; text-transform: uppercase; font-size: 12px;">Qty</th>
                                <th style="border: 1px solid #ddd; padding: 10px; font-weight: bold; text-transform: uppercase; font-size: 12px;">Unit Price</th>
                                <th style="border: 1px solid #ddd; padding: 10px; font-weight: bold; text-transform: uppercase; font-size: 12px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                            <tr style="background-color: @if($loop->even) #f9f9f9 @endif;">
                                <td style="border: 1px solid #ddd; padding: 10px;">{{ $item->product->name }}</td>
                                <td style="border: 1px solid #ddd; padding: 10px;">{{ $item->quantity }}</td>
                                <td style="border: 1px solid #ddd; padding: 10px;">TSh {{ number_format($item->price, 2) }}</td>
                                <td style="border: 1px solid #ddd; padding: 10px;">TSh {{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="total text-end" style="font-size: 20px; font-weight: bold; color: #851b2d; margin-top: 20px; padding: 10px; background-color: #e8f5e8; border-radius: 5px;">
                        Grand Total: TSh {{ number_format($sale->total, 2) }}
                    </div>

                    <div class="footer text-center mt-4" style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #851b2d; color: #666; font-size: 12px;">
                        <p>Thank you for your business!</p>
                        <p>Visit us again at Agrovet</p>
                        <div class="mt-3">
                            <a href="{{ route('web.pos.index') }}" class="btn btn-primary me-2">New Sale</a>
                            <button onclick="window.print()" class="btn btn-secondary">Print Receipt</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
