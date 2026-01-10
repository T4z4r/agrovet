@extends('layouts.master')

@section('title', 'Edit Privacy Policy')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Privacy Policy</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('web.privacy-policies.update', $privacyPolicy) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $privacyPolicy->title) }}" required>
                            @error('title')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="10" required>{{ old('content', $privacyPolicy->content) }}</textarea>
                            @error('content')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $privacyPolicy->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Is Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('web.privacy-policies.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        height: 400,
        menubar: false,
        plugins: 'lists link image code',
        toolbar: 'bold italic underline | bullist numlist | link image | code',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }'
    });
</script>
@endsection
