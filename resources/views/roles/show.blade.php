@extends('layouts.master')

@section('title', 'Role Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $role->name }}</h5>
                <div>
                    <a href="{{ route('web.roles.edit', $role) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('web.roles.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Name:</strong> {{ $role->name }}
                </div>
                <div class="mb-3">
                    <strong>Permissions:</strong>
                    @if($role->permissions->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($role->permissions as $permission)
                                <li class="list-group-item">{{ $permission->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">No permissions assigned</span>
                    @endif
                </div>
                <div class="mb-3">
                    <strong>Users Count:</strong> {{ $role->users()->count() }}
                </div>
                <div class="mb-3">
                    <strong>Created At:</strong> {{ $role->created_at->format('Y-m-d H:i:s') }}
                </div>
                <div class="mb-3">
                    <strong>Updated At:</strong> {{ $role->updated_at->format('Y-m-d H:i:s') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
