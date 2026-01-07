@extends('layouts.master')

@section('title', 'Roles Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Roles</h5>
                <a href="{{ route('web.roles.create') }}" class="btn btn-primary">Add Role</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Users Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->permissions->pluck('name')->join(', ') }}</td>
                                <td>{{ $role->users()->count() }}</td>
                                <td>
                                    <a href="{{ route('web.roles.show', $role) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('web.roles.edit', $role) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @if($role->name !== 'owner')
                                    <form method="POST" action="{{ route('web.roles.destroy', $role) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                    @endif
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