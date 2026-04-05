@extends('layouts.master')

@section('title', 'Privacy Policy')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $privacyPolicy->title }}</h5>
                <div>
                    @can('edit privacy policies')
                        <a href="{{ route('web.privacy-policies.edit', $privacyPolicy) }}" class="btn btn-warning">Edit</a>
                    @endcan
                    <a href="{{ route('web.privacy-policies.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status:</strong>
                    @if($privacyPolicy->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </div>
                <div class="mb-3">
                    <strong>Created At:</strong> {{ $privacyPolicy->created_at->format('Y-m-d H:i:s') }}
                </div>
                <div class="mb-3">
                    <strong>Updated At:</strong> {{ $privacyPolicy->updated_at->format('Y-m-d H:i:s') }}
                </div>
                <div>
                    <strong>Content:</strong>
                    <div class="mt-2">{!! $privacyPolicy->content !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
