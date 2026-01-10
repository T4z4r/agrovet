@extends('layouts.guest')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">{{ $privacyPolicy->title }}</h1>
            <div class="prose dark:prose-invert max-w-none">
                {!! nl2br(e($privacyPolicy->content)) !!}
            </div>
            <div class="mt-8 text-sm text-gray-500 dark:text-gray-400">
                Last updated: {{ $privacyPolicy->updated_at->format('F j, Y') }}
            </div>
        </div>
    </div>
</div>
@endsection
