@extends('layouts.master')

@section('title', 'Edit Staff Member')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Staff Member</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('staff.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" placeholder="Enter staff name" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" placeholder="Enter email address" required>
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">New Password <span
                                        class="text-muted">(optional)</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Leave blank to keep current">
                                    <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="password" tabindex="-1">
                                        <i class="bx bx-hide"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="seller" {{ old('role', $user->role) == 'seller' ? 'selected' : '' }}>
                                        Seller</option>
                                    <option value="owner" {{ old('role', $user->role) == 'owner' ? 'selected' : '' }}>Owner
                                    </option>
                                </select>
                                @error('role')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shop_id" class="form-label">Shop</label>
                                <select class="form-select" id="shop_id" name="shop_id" required>
                                    <option value="">Select Shop</option>
                                    @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}"
                                            {{ old('shop_id', $user->shop_id) == $shop->id ? 'selected' : '' }}>
                                            {{ $shop->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('shop_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="branch_id" class="form-label">Branch <span
                                        class="text-muted">(optional)</span></label>
                                <select class="form-select" id="branch_id" name="branch_id">
                                    <option value="">No Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Staff</button>
                        <a href="{{ route('staff.show', $user) }}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
