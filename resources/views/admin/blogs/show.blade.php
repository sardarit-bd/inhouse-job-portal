@extends('layouts.admin')

@section('page-title', 'Blogs Management')
@section('page-subtitle', 'Manage all blogs')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Blog Post Details
                </h2>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        By {{ $blog->author_name }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Published on {{ $blog->published_at ? $blog->published_at->format('F d, Y') : 'Not published' }}
                    </div>
                </div>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                <a href="{{ route('admin.blogs.edit', $blog) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Edit
                </a>
                <a href="{{ route('blogs.show', $blog->slug) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    View Live
                </a>
                <a href="{{ route('admin.blogs.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Content -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <!-- Featured Image -->
                    @if($blog->featured_image)
                    <div class="h-auto overflow-hidden">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                             alt="{{ $blog->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                    @endif

                    <div class="px-4 py-5 sm:px-6">
                        <!-- Title & Status -->
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $blog->title }}</h1>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $blog->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </span>
                                @if($blog->is_featured)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Featured
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $blog->reading_time }} min read
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ $blog->views }} views
                            </div>
                            @if($blog->category)
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">
                                {{ $blog->category }}
                            </span>
                            @endif
                        </div>

                        <!-- Excerpt -->
                        @if($blog->excerpt)
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <p class="text-blue-800 italic">{{ $blog->excerpt }}</p>
                        </div>
                        @endif

                        <!-- Content -->
                        <div class="prose max-w-none">
                            {!! nl2br(e($blog->content)) !!}
                        </div>

                        <!-- Tags -->
                        @if($blog->tags && count($blog->tags) > 0)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($blog->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $tag }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Stats & Actions -->
            <div class="space-y-6">
                <!-- Stats -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Post Statistics</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Status</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                    <span class="{{ $blog->is_published ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $blog->is_published ? 'Live' : 'Draft' }}
                                    </span>
                                </dd>
                            </div>
                            <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Views</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $blog->views }}</dd>
                            </div>
                            <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Category</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $blog->category ?? 'General' }}</dd>
                            </div>
                            <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Reading Time</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $blog->reading_time }} min</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <div class="space-y-3">
                            <form action="{{ route('admin.blogs.toggle-status', $blog) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white 
                                            {{ $blog->is_published ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} 
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ $blog->is_published ? 'Unpublish Post' : 'Publish Post' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.blogs.toggle-featured', $blog) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ $blog->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                                </button>
                            </form>

                            <a href="{{ route('blogs.show', $blog->slug) }}" 
                               target="_blank"
                               class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View Live
                            </a>

                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this blog post? This action cannot be undone.')"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Delete Post
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- SEO Info -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">SEO Information</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Meta Title</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $blog->meta_title ?? 'Not set' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Meta Description</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $blog->meta_description ?? 'Not set' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Meta Keywords</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $blog->meta_keywords ?? 'Not set' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">URL Slug</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $blog->slug }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.prose {
    color: #374151;
    line-height: 1.75;
}
.prose p {
    margin-top: 1.25em;
    margin-bottom: 1.25em;
}
.prose h2 {
    color: #111827;
    font-weight: 700;
    font-size: 1.5em;
    margin-top: 2em;
    margin-bottom: 1em;
    line-height: 1.3333333;
}
.prose h3 {
    color: #111827;
    font-weight: 600;
    font-size: 1.25em;
    margin-top: 1.6em;
    margin-bottom: 0.6em;
    line-height: 1.6;
}
.prose ul {
    list-style-type: disc;
    margin-top: 1.25em;
    margin-bottom: 1.25em;
    padding-left: 1.625em;
}
.prose ol {
    list-style-type: decimal;
    margin-top: 1.25em;
    margin-bottom: 1.25em;
    padding-left: 1.625em;
}
.prose li {
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}
</style>
@endpush