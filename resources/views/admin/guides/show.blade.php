@extends('layouts.master')

@section('title', 'Guide Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Guide Details</h5>
                <div>
                    @if($guide->file_path)
                        <a href="{{ route('admin.guides.download', $guide) }}" class="btn btn-success btn-sm">
                            <i class="bx bx-download"></i> Download File
                        </a>
                    @endif
                    <a href="{{ route('admin.guides.edit', $guide) }}" class="btn btn-warning btn-sm">
                        <i class="bx bx-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.guides.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <h6 class="text-muted">Title</h6>
                            <p class="h5">{{ $guide->title }}</p>
                        </div>

                        @if($guide->content)
                        <div class="mb-3">
                            <h6 class="text-muted">Content</h6>
                            <div class="border p-3 rounded">
                                {!! nl2br(e($guide->content)) !!}
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <h6 class="text-muted">Language</h6>
                            <p>{{ $guide->language === 'en' ? 'English' : 'Swahili' }}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted">Target Role</h6>
                            <p>
                                @switch($guide->target_role)
                                    @case('owner')
                                        Owner
                                        @break
                                    @case('seller')
                                        Seller
                                        @break
                                    @case('both')
                                        Both
                                        @break
                                @endswitch
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted">Created By</h6>
                            <p>{{ $guide->creator->name ?? 'Unknown' }}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted">Created At</h6>
                            <p>{{ $guide->created_at->format('M d, Y H:i') }}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted">Updated At</h6>
                            <p>{{ $guide->updated_at->format('M d, Y H:i') }}</p>
                        </div>

                        @if($guide->file_path)
                        <div class="mb-3">
                            <h6 class="text-muted">Attached File</h6>
                            <p>{{ basename($guide->file_path) }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection