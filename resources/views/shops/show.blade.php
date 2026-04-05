@extends('layouts.master')

@section('title', 'Shop Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Shop Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Name:</strong> {{ $shop->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Location:</strong> {{ $shop->location }}
                    </div>
                    <div class="col-md-6">
                        <strong>Owner:</strong> {{ $shop->owner->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Created At:</strong> {{ $shop->created_at->format('Y-m-d H:i') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Updated At:</strong> {{ $shop->updated_at->format('Y-m-d H:i') }}
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('web.shops.edit', $shop) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('web.shops.index') }}" class="btn btn-secondary">Back to Shops</a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Branches</h5>
                <a href="{{ route('web.branches.create') }}" class="btn btn-primary">Add Branch</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shop->branches as $branch)
                            <tr>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->location }}</td>
                                <td>
                                    <a href="{{ route('web.branches.show', $branch) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('web.branches.edit', $branch) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('web.branches.destroy', $branch) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
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
    </div>
</div>
@endsection
