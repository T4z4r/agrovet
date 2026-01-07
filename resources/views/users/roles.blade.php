@extends('layouts.master')

@section('title', 'Manage Roles - ' . $user->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Roles for {{ $user->name }}</h5>
                <a href="{{ route('web.users.index') }}" class="btn btn-secondary">Back to Users</a>
            </div>
            <div class="card-body">
                <h6>Current Roles</h6>
                <ul class="list-group mb-3">
                    @forelse($user->roles as $role)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $role->name }}
                            <form method="POST" action="{{ route('web.users.removeRole', [$user->id, $role->id]) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </li>
                    @empty
                        <li class="list-group-item">No roles assigned</li>
                    @endforelse
                </ul>

                <h6>Assign New Role</h6>
                <form method="POST" action="{{ route('web.users.assignRole', $user) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <select name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    @if(!$user->hasRole($role))
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Assign Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
