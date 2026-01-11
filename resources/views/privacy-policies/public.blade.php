@extends('layouts.public')

@section('title', $privacyPolicy->title)

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h1 class="card-title h2 fw-bold text-dark mb-4">{{ $privacyPolicy->title }}</h1>
                    <div class="content">
                        {!! $privacyPolicy->content !!}
                    </div>
                    <hr class="my-4">
                    <small class="text-muted">
                        Last updated: {{ $privacyPolicy->updated_at->format('F j, Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
