@extends('layouts.master')

@section('title', 'Staff Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Staff Details</h5>
                <div>
                    <a href="{{ route('staff.edit', $user) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('staff.index') }}" class="btn btn-secondary">Back to Staff</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <strong>Name:</strong> {{ $user->name }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                     <div class="col-md-6 mb-2">
                         <strong>Role:</strong> {{ ucfirst($user->role) }}
                     </div>
                    <div class="col-md-6 mb-2">
                        <strong>Shop:</strong> {{ $user->assignedShop->name ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Branch:</strong> {{ $user->branch->name ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Status:</strong>
                        @if($user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Created At:</strong> {{ $user->created_at->format('Y-m-d H:i') }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Updated At:</strong> {{ $user->updated_at->format('Y-m-d H:i') }}
                    </div>
                </div>



                {{-- Delete --}}
                <div class="mt-3">
                    <form method="POST" action="{{ route('staff.destroy', $user) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this staff member?')">
                            Delete Staff Member
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
