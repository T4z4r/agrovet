@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit User</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('web.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter full name" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter email address" required>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password (leave blank to keep current)</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password" aria-label="Show password">
                                    <i class="bx bx-hide"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation" aria-label="Show password">
                                    <i class="bx bx-hide"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('web.users.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
