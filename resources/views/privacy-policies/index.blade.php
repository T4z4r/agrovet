@extends('layouts.master')

@section('title', 'Privacy Policies')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Privacy Policies</h5>
                @can('create privacy policies')
                    <a href="{{ route('web.privacy-policies.create') }}" class="btn btn-primary">Add Privacy Policy</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($privacyPolicies as $policy)
                            <tr>
                                <td>{{ $policy->title }}</td>
                                <td>
                                    @if($policy->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $policy->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('web.privacy-policies.show', $policy) }}" class="btn btn-sm btn-info">View</a>
                                    @can('edit privacy policies')
                                        <a href="{{ route('web.privacy-policies.edit', $policy) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @endcan
                                    @can('delete privacy policies')
                                        <form method="POST" action="{{ route('web.privacy-policies.destroy', $policy) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    @endcan
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
