@extends('layouts.master')

@section('title', 'Staff')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Staff</h5>
                    <a href="{{ route('staff.create') }}" class="btn btn-primary">Add Staff</a>
                </div>
                <div class="card-body">
                    {{-- Filters --}}
                    <form method="GET" action="{{ route('staff.index') }}" class="row g-2 mb-3">
                        <div class="col-md-3">
                            <select name="shop_id" class="form-select">
                                <option value="">All Shops</option>
                                @foreach ($shops as $shop)
                                    <option value="{{ $shop->id }}"
                                        {{ request('shop_id') == $shop->id ? 'selected' : '' }}>
                                        {{ $shop->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="branch_id" class="form-select">
                                <option value="">All Branches</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="role" class="form-select">
                                <option value="">All Roles</option>
                                <option value="seller" {{ request('role') === 'seller' ? 'selected' : '' }}>Seller</option>
                                <option value="manager" {{ request('role') === 'manager' ? 'selected' : '' }}>Manager
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary w-100">Filter</button>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Shop</th>
                                    {{-- <th>Branch</th> --}}
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staff as $member)
                                    <tr>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->roles->pluck('name')->join(', ') }}</td>
                                        <td>{{ $member->assignedShop->name ?? '-' }}</td>
                                        {{-- <td>{{ $member->branch->name ?? '-' }}</td> --}}
                                        <td>
                                            @if ($member->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('staff.show', $member) }}"
                                                class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('staff.edit', $member) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form method="POST" action="{{ route('staff.destroy', $member) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No staff members found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $staff->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
