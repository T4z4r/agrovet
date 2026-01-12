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
                                        <form method="POST" action="{{ route('web.privacy-policies.destroy', $policy) }}" class="d-inline" id="delete-form-{{ $policy->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $policy->id }})">Delete</button>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d6d6d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection
