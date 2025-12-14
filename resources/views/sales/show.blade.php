@extends('layouts.master')

@section('title', 'Sale Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sale #{{ $sale->id }}</h5>
                <a href="{{ route('web.sales.receipt', $sale) }}" class="btn btn-secondary">Download Receipt</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Seller:</strong> {{ $sale->seller->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Date:</strong> {{ $sale->sale_date }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Total:</strong> {{ $sale->total }}
                    </div>
                </div>

                <h6>Items</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('web.sales.index') }}" class="btn btn-secondary">Back to Sales</a>
            </div>
        </div>
    </div>
</div>
@endsection
