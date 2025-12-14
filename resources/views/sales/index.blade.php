@extends('layouts.master')

@section('title', 'Sales')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sales</h5>
                <a href="{{ route('web.sales.create') }}" class="btn btn-primary">Add Sale</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Seller</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->seller->name }}</td>
                                <td>{{ $sale->total }}</td>
                                <td>{{ $sale->sale_date }}</td>
                                <td>
                                    <a href="{{ route('web.sales.show', $sale) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('web.sales.receipt', $sale) }}" class="btn btn-sm btn-secondary">Receipt</a>
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
