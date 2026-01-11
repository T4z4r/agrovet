@extends('layouts.public')

@section('title', $privacyPolicy->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-sm border p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $privacyPolicy->title }}</h1>
        <div class="prose prose-gray max-w-none">
            {!! $privacyPolicy->content !!}
        </div>
        <div class="mt-8 pt-6 border-t text-sm text-gray-500">
            Last updated: {{ $privacyPolicy->updated_at->format('F j, Y') }}
        </div>
    </div>
</div>
@endsection
