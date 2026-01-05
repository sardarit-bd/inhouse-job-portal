@extends('layouts.app')

@section('title', "{$job->title} | Join Our Team")


@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Card container -->
    <div class="bg-white shadow-lg rounded-xl p-8 md:p-12 space-y-6">

        <!-- Header: Job & Company -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                @if($job->company_logo)
                    <img src="{{ $job->company_logo }}" alt="{{ $job->company_name }}"
                         class="w-16 h-16 rounded-lg object-cover">
                @else
                    <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500 font-bold">{{ substr($job->company_name,0,2) }}</span>
                    </div>
                @endif

                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $job->title }}</h1>
                    <p class="text-gray-600 text-sm md:text-base">
                        {{ $job->company_name }} • {{ $job->location }}
                    </p>
                </div>
            </div>

            <!-- Salary & Type -->
            <div class="flex flex-col md:items-end gap-2">
                <span class="text-indigo-600 font-semibold text-lg">
                    💰 {{ $job->salary ?? 'Negotiable' }}
                </span>
                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-sm font-medium">
                    {{ ucfirst($job->job_type) }}
                </span>
            </div>
        </div>

        <!-- Description -->
        <div class="text-gray-700 space-y-4">
            <h2 class="text-xl font-semibold">Job Description</h2>
            <p>{{ $job->description }}</p>
        </div>

        <!-- Experience & Deadline -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <div>
                <h3 class="font-semibold">Experience Level</h3>
                <p>{{ ucfirst($job->experience_level) }}</p>
            </div>
            <div>
                <h3 class="font-semibold">Application Deadline</h3>
                <p>{{ $job->application_deadline->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Skills -->
        @if(!empty($job->skills_required))
            <div>
                <h3 class="font-semibold mb-2">Skills Required</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($job->skills_required as $skill)
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Benefits -->
        @if(!empty($job->benefits))
            <div>
                <h3 class="font-semibold mb-2">Benefits</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($job->benefits as $benefit)
                        <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm">{{ $benefit }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Apply CTA -->
        <div class="pt-6 border-t flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            @if($job->is_active && $job->status === 'approved')
                @if($hasApplied)
                    <span class="text-gray-500 font-semibold">✅ You have already applied</span>
                @else
                    <a href="{{ route('jobs.apply', $job->id) }}"
                       class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-bold text-lg hover:bg-indigo-700 transition">
                        Apply Now
                    </a>
                @endif
            @else
                <span class="text-red-500 font-semibold">This job is closed</span>
            @endif

            <span class="text-gray-400 text-sm">👀 {{ $job->views }} views</span>
        </div>
    </div>

</section>
@endsection
