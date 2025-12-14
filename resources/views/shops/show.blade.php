@extends('layouts.master')

@section('title', 'Shop Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Shop Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Name:</strong> {{ $shop->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Location:</strong> {{ $shop->location }}
                    </div>
                    <div class="col-md-6">
                        <strong>Owner:</strong> {{ $shop->owner->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Created At:</strong> {{ $shop->created_at->format('Y-m-d H:i') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Updated At:</strong> {{ $shop->updated_at->format('Y-m-d H:i') }}
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('web.shops.edit', $shop) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('web.shops.index') }}" class="btn btn-secondary">Back to Shops</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection