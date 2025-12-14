@extends('layouts.master')

@section('title', 'User Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Name:</strong> {{ $user->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                    <div class="col-md-6">
                        <strong>Role:</strong> {{ $user->role }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        @if($user->is_active)
                            <span class="badge bg-primary">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong>Created At:</strong> {{ $user->created_at->format('Y-m-d H:i') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Updated At:</strong> {{ $user->updated_at->format('Y-m-d H:i') }}
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('web.users.edit', $user) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('web.users.index') }}" class="btn btn-secondary">Back to Users</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection