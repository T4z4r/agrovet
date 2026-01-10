@extends('layouts.master')

@section('title', 'Edit Subscription Package')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Subscription Package</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.subscription-packages.update', $package->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $package->name) }}" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $package->price) }}" required min="0" step="0.01">
                            @error('price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="duration_months" class="form-label">Duration (Months)</label>
                            <input type="number" class="form-control" id="duration_months" name="duration_months" value="{{ old('duration_months', $package->duration_months) }}" required min="1">
                            @error('duration_months')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="is_active" class="form-label">Active</label>
                            <select class="form-control" id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', $package->is_active) ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('is_active', $package->is_active) ? '' : 'selected' }}>No</option>
                            </select>
                            @error('is_active')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $package->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="feature_ids" class="form-label">Features</label>
                            <select class="form-control" id="feature_ids" name="feature_ids[]" multiple>
                                @foreach($features as $feature)
                                    <option value="{{ $feature->id }}" {{ in_array($feature->id, old('feature_ids', $package->features->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $feature->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('feature_ids')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.subscription-packages.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection