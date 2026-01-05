@extends('layouts.app')

@section('title', 'Find Your Dream Job | JobPortal')

@section('content')
    <!-- Hero Section v3 -->
    <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 text-white overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative h-[75vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">

                <!-- Headline -->
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Join Our Team & <span class="text-yellow-300">Grow With Us</span>
                </h1>

                <!-- Sub headline -->
                <p class="text-lg sm:text-xl md:text-2xl opacity-90 mb-10">
                    We’re building a team of passionate people who love to learn, grow,
                    and create meaningful impact together.
                </p>

                <!-- Search / CTA -->
                <div class="max-w-3xl mx-auto">
                    <form action="{{ route('jobs.index') }}" method="GET" class="bg-white rounded-xl shadow-2xl p-2">
                        <div class="flex flex-col md:flex-row gap-4">
                            <input type="text" name="search" placeholder="Search open positions"
                                class="flex-1 px-6 py-4 text-gray-900 rounded-lg focus:ring-2 focus:ring-indigo-500 text-lg" />

                            <button type="submit"
                                class="bg-gradient-to-r from-indigo-600 to-purple-600
                                   hover:from-indigo-700 hover:to-purple-700
                                   transition text-white px-10 py-4 rounded-lg
                                   font-bold text-lg whitespace-nowrap">
                                View Open Roles
                            </button>
                        </div>
                    </form>

                    <!-- Quick highlights -->
                    <div class="mt-8 flex flex-wrap justify-center gap-6 text-sm sm:text-base opacity-90">
                        <div>🚀 Career Growth</div>
                        <div>🤝 Collaborative Team</div>
                        <div>🏠 Flexible Work</div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Stats Section -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">10,000+</div>
                    <div class="text-gray-600">Active Jobs</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">5,000+</div>
                    <div class="text-gray-600">Companies</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">50,000+</div>
                    <div class="text-gray-600">Professionals</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">95%</div>
                    <div class="text-gray-600">Success Rate</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Jobs -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Featured Jobs</h2>
                    <p class="text-gray-600 mt-2">Hand-picked opportunities from top companies</p>
                </div>
                <a href="{{ route('jobs.index') }}" class="text-indigo-600 font-semibold hover:text-indigo-800">
                    View All Jobs →
                </a>
            </div>

            @if ($featuredJobs && $featuredJobs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($featuredJobs as $job)
                        <x-card class="job-card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center space-x-4">
                                        @if ($job->company_logo)
                                            <img src="{{ asset('storage/' . $job->company_logo) }}"
                                                alt="{{ $job->company_name }}"
                                                class="w-14 h-14 rounded-xl object-cover border border-gray-200">
                                        @else
                                            <div
                                                class="w-14 h-14 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                                <span
                                                    class="text-2xl font-bold text-indigo-600">{{ substr($job->company_name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-bold text-lg text-gray-900">{{ $job->title }}</h3>
                                            <p class="text-gray-600">{{ $job->company_name }}</p>
                                        </div>
                                    </div>
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        Featured
                                    </span>
                                </div>

                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $job->location }}</span>
                                    </div>

                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ ucfirst($job->job_type) }}</span>
                                    </div>

                                    @if ($job->salary)
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>${{ number_format($job->salary) }}/year</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex space-x-2">
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">{{ $job->experience_level }}</span>
                                        <span
                                            class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full">{{ $job->job_type }}</span>
                                    </div>
                                    <a href="{{ route('jobs.show', $job) }}"
                                        class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                                        Apply Now →
                                    </a>
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Featured Jobs Available</h3>
                    <p class="text-gray-600">Check back soon for new opportunities!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Categories -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Browse by Category</h2>
                <p class="text-gray-600 mt-2">Find jobs in your area of expertise</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @php
                    $categories = [
                        'tech' => ['icon' => '💻', 'title' => 'Technology', 'jobs' => '1,234'],
                        'design' => ['icon' => '🎨', 'title' => 'Design', 'jobs' => '567'],
                        'marketing' => ['icon' => '📈', 'title' => 'Marketing', 'jobs' => '890'],
                        'finance' => ['icon' => '💰', 'title' => 'Finance', 'jobs' => '432'],
                        'healthcare' => ['icon' => '🏥', 'title' => 'Healthcare', 'jobs' => '765'],
                        'education' => ['icon' => '📚', 'title' => 'Education', 'jobs' => '321'],
                    ];
                @endphp

                @foreach ($categories as $key => $category)
                    <a href="{{ route('jobs.index') }}?search={{ $category['title'] }}"
                        class="group p-6 bg-gray-50 rounded-xl hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition duration-300 border border-gray-200 hover:border-indigo-200 text-center">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform duration-300">
                            {{ $category['icon'] }}</div>
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $category['title'] }}</h3>
                        <p class="text-sm text-gray-500">{{ $category['jobs'] }} Jobs</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="py-16 bg-gradient-to-r from-gray-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">How It Works</h2>
                <p class="text-gray-600 mt-2">Get your dream job in 3 simple steps</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Create Profile</h3>
                    <p class="text-gray-600">Sign up and build your professional profile with skills and experience</p>
                </div>

                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Search & Apply</h3>
                    <p class="text-gray-600">Browse thousands of jobs and apply with one click</p>
                </div>

                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Get Hired</h3>
                    <p class="text-gray-600">Connect with employers and start your new career</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:from-indigo-700 hover:to-purple-700 transition duration-300 shadow-lg hover:shadow-xl">
                    Start Your Journey
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Success Stories</h2>
                <p class="text-gray-600 mt-2">See what our users have to say</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <x-card class="p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-blue-100 to-cyan-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xl mr-4">
                            S
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Sarah Johnson</h4>
                            <p class="text-gray-600 text-sm">Software Engineer at Google</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Found my dream job within 2 weeks of joining JobPortal. The platform
                        made it so easy to connect with top tech companies!"</p>
                    <div class="flex text-yellow-400 mt-4">
                        ★★★★★
                    </div>
                </x-card>

                <x-card class="p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-green-100 to-emerald-100 rounded-full flex items-center justify-center text-green-600 font-bold text-xl mr-4">
                            M
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Michael Chen</h4>
                            <p class="text-gray-600 text-sm">Product Designer at Apple</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"The quality of job listings is exceptional. I received interview
                        requests from companies I never thought would notice me."</p>
                    <div class="flex text-yellow-400 mt-4">
                        ★★★★★
                    </div>
                </x-card>

                <x-card class="p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-purple-100 to-pink-100 rounded-full flex items-center justify-center text-purple-600 font-bold text-xl mr-4">
                            R
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Raj Patel</h4>
                            <p class="text-gray-600 text-sm">Marketing Director at Amazon</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"As an employer, JobPortal helped me find the perfect candidates. The
                        matching algorithm is spot on!"</p>
                    <div class="flex text-yellow-400 mt-4">
                        ★★★★★
                    </div>
                </x-card>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Transform Your Career?</h2>
            <p class="text-xl opacity-90 mb-8">Join thousands of professionals who have found their perfect career match
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-white text-indigo-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl">
                    Get Started Free
                </a>
                <a href="{{ route('jobs.index') }}"
                    class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-indigo-600 transition duration-300">
                    Browse Jobs
                </a>
            </div>
            <p class="mt-6 opacity-80">No credit card required • 30-day free trial</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-rotate featured jobs (optional)
        document.addEventListener('DOMContentLoaded', function() {
            const jobCards = document.querySelectorAll('.job-card');
            jobCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-4px)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endpush
