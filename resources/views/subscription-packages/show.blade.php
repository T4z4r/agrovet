@extends('layouts.master')

@section('title', 'View Subscription Package')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Subscription Package Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Name:</h6>
                        <p>{{ $package->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Price:</h6>
                        <p>${{ number_format($package->price, 2) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Duration:</h6>
                        <p>{{ $package->duration_months }} months</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Status:</h6>
                        <p>{{ $package->is_active ? 'Active' : 'Inactive' }}</p>
                    </div>
                    <div class="col-md-12">
                        <h6>Description:</h6>
                        <p>{{ $package->description ?: 'No description' }}</p>
                    </div>
                    <div class="col-md-12">
                        <h6>Features:</h6>
                        @if($package->features && $package->features->count() > 0)
                            <ul>
                                @foreach($package->features as $feature)
                                    <li>{{ $feature->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No features assigned</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.subscription-packages.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection