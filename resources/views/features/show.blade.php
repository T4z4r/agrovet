@extends('layouts.master')

@section('title', 'View Feature')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Feature Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Name:</h6>
                        <p>{{ $feature->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Status:</h6>
                        <p>{{ $feature->is_active ? 'Active' : 'Inactive' }}</p>
                    </div>
                    <div class="col-md-12">
                        <h6>Description:</h6>
                        <p>{{ $feature->description ?: 'No description' }}</p>
                    </div>
                    <div class="col-md-12">
                        <h6>Subscription Packages:</h6>
                        @if($feature->subscriptionPackages->count() > 0)
                            <ul>
                                @foreach($feature->subscriptionPackages as $package)
                                    <li>{{ $package->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Not assigned to any subscription packages</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.features.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection