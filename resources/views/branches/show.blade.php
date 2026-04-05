@extends('layouts.master')

@section('title', 'Branch Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Branch Details</h5>
                <a href="{{ route('web.branches.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $branch->name }}</p>
                        <p><strong>Location:</strong> {{ $branch->location }}</p>
                        <p><strong>Shop:</strong> {{ $branch->shop->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
