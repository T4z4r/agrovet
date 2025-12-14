@extends('layouts.master')

@section('title', 'Shops')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Shops</h5>
                <a href="{{ route('web.shops.create') }}" class="btn btn-primary">Add Shop</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Owner</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shops as $shop)
                            <tr>
                                <td>{{ $shop->name }}</td>
                                <td>{{ $shop->location }}</td>
                                <td>{{ $shop->owner->name }}</td>
                                <td>
                                    <a href="{{ route('web.shops.show', $shop) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('web.shops.edit', $shop) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('web.shops.destroy', $shop) }}" class="d-inline">
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
@endsection