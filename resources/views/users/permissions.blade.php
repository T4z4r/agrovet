@extends('layouts.master')

@section('title', 'Manage Permissions - ' . $user->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Permissions for {{ $user->name }}</h5>
                <a href="{{ route('web.users.index') }}" class="btn btn-secondary">Back to Users</a>
            </div>
            <div class="card-body">
                <h6>Current Permissions</h6>
                <ul class="list-group mb-3">
                    @forelse($user->permissions as $permission)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $permission->name }}
                            <form method="POST" action="{{ route('web.users.revokePermission', [$user->id, $permission->id]) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Revoke</button>
                            </form>
                        </li>
                    @empty
                        <li class="list-group-item">No direct permissions assigned</li>
                    @endforelse
                </ul>

                <h6>Grant New Permission</h6>
                <form method="POST" action="{{ route('web.users.givePermission', $user) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <select name="permission" class="form-control" required>
                                <option value="">Select Permission</option>
                                @foreach($permissions as $permission)
                                    @if(!$user->hasPermissionTo($permission))
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Grant Permission</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
