@extends('layouts.master')

@section('title', 'Create Guide')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create New Guide</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.guides.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          id="content" name="content" rows="6">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="language" class="form-label">Language <span class="text-danger">*</span></label>
                                <select class="form-control @error('language') is-invalid @enderror"
                                        id="language" name="language" required>
                                    <option value="">Select Language</option>
                                    <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="sw" {{ old('language') == 'sw' ? 'selected' : '' }}>Swahili</option>
                                </select>
                                @error('language')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="target_role" class="form-label">Target Role <span class="text-danger">*</span></label>
                                <select class="form-control @error('target_role') is-invalid @enderror"
                                        id="target_role" name="target_role" required>
                                    <option value="">Select Target Role</option>
                                    <option value="owner" {{ old('target_role') == 'owner' ? 'selected' : '' }}>Owner</option>
                                    <option value="seller" {{ old('target_role') == 'seller' ? 'selected' : '' }}>Seller</option>
                                    <option value="both" {{ old('target_role') == 'both' ? 'selected' : '' }}>Both</option>
                                </select>
                                @error('target_role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">File (Optional)</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                       id="file" name="file" accept=".pdf,.doc,.docx,.txt">
                                <div class="form-text">Allowed formats: PDF, DOC, DOCX, TXT. Max size: 10MB</div>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.guides.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Guide</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
