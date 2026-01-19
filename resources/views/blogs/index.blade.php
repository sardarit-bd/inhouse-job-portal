@extends('layouts.app')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<!-- Page Header -->
<section class="relative py-16 bg-gradient-to-r from-[#1C4D8D] to-[#4988C4] text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Career Insights & Tips</h1>
            <p class="text-xl opacity-90">Stay updated with the latest career advice, industry trends, and professional development tips from our experts.</p>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Featured Blogs -->
                @if($featuredBlogs->count() > 0)
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 pb-4 border-b border-gray-200">Featured Articles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($featuredBlogs as $blog)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            @if($blog->featured_image)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                     alt="{{ $blog->title }}" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <span class="bg-[#BDE8F5] text-[#1C4D8D] px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $blog->category ?? 'Career Tips' }}
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '' }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
                                    <a href="{{ route('blogs.show', $blog->slug) }}" class="hover:text-[#1C4D8D] transition-colors">
                                        {{ $blog->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 120) }}
                                </p>
                                <a href="{{ route('blogs.show', $blog->slug) }}" 
                                   class="inline-flex items-center text-[#1C4D8D] hover:text-[#4988C4] font-medium">
                                    Read More
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- All Blogs -->
                <div>
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                        <h2 class="text-3xl font-bold text-gray-800">All Articles</h2>
                        <div class="text-gray-600">
                            <span class="font-medium">{{ $blogs->total() }}</span> articles found
                        </div>
                    </div>

                    @if($blogs->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($blogs as $blog)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            @if($blog->featured_image)
                            <div class="h-40 overflow-hidden">
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                     alt="{{ $blog->title }}" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                            @endif
                            <div class="p-5">
                                <div class="flex items-center text-xs text-gray-500 mb-2">
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                        {{ $blog->category ?? 'General' }}
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $blog->published_at ? $blog->published_at->format('M d') : '' }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                    <a href="{{ route('blogs.show', $blog->slug) }}" class="hover:text-[#1C4D8D] transition-colors">
                                        {{ $blog->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                                    {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 100) }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('blogs.show', $blog->slug) }}" 
                                       class="text-sm text-[#1C4D8D] hover:text-[#4988C4] font-medium">
                                        Read More →
                                    </a>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ $blog->views }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $blogs->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No blog posts available</h3>
                        <p class="mt-2 text-gray-600">Check back later for new articles and insights.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <!-- Categories -->
                @if($categories->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Categories</h3>
                    <ul class="space-y-2">
                        @foreach($categories as $category)
                        <li>
                            <a href="?category={{ urlencode($category) }}" 
                               class="flex items-center justify-between text-gray-600 hover:text-[#1C4D8D] transition-colors">
                                <span>{{ $category }}</span>
                                <span class="text-xs bg-gray-100 px-2 py-1 rounded">
                                    @php
                                        $categoryCount = App\Models\Blog::published()
                                            ->where('category', $category)
                                            ->count();
                                    @endphp
                                    {{ $categoryCount }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Popular Posts -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Popular Articles</h3>
                    @php
                        $popularBlogs = App\Models\Blog::published()
                            ->orderBy('views', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($popularBlogs->count() > 0)
                    <div class="space-y-4">
                        @foreach($popularBlogs as $blog)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-[#1C4D8D]"></div>
                            <div>
                                <a href="{{ route('blogs.show', $blog->slug) }}" 
                                   class="text-sm font-medium text-gray-800 hover:text-[#1C4D8D] line-clamp-2">
                                    {{ $blog->title }}
                                </a>
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    <span>{{ $blog->published_at ? $blog->published_at->format('M d') : '' }}</span>
                                    <span class="mx-1">•</span>
                                    <span>{{ $blog->views }} views</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Newsletter -->
                <div class="bg-gradient-to-r from-[#1C4D8D] to-[#4988C4] rounded-lg shadow-md p-6 mt-6 text-white">
                    <h3 class="text-lg font-bold mb-2">Stay Updated</h3>
                    <p class="text-sm opacity-90 mb-4">Get the latest career tips and job search advice directly in your inbox.</p>
                    <form class="space-y-3">
                        <input type="email" 
                               placeholder="Your email address" 
                               class="w-full px-4 py-2 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white">
                        <button type="submit" 
                                class="w-full bg-white text-[#1C4D8D] px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection