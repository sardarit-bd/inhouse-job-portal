@extends('layouts.app')

@section('title', 'My Applications')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Job Applications</h1>

    @if($applications->isEmpty())
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-xl font-medium text-gray-900 mb-2">No applications yet</h3>
            <p class="text-gray-600 mb-6">You haven't applied to any jobs yet.</p>
            <a href="{{ route('jobs.index') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Browse Jobs
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($applications as $application)
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900">
                            <a href="{{ route('jobs.show', $application->job) }}" class="hover:text-indigo-600">
                                {{ $application->job->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600">{{ $application->job->company_name }}</p>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                {{ $application->job->location }}
                            </span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                {{ ucfirst($application->job->job_type) }}
                            </span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                {{ ucfirst($application->job->experience_level) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end">
                        <div class="mb-2">
                            @switch($application->status)
                                @case('pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                        Pending Review
                                    </span>
                                    @break
                                @case('reviewed')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        Under Review
                                    </span>
                                    @break
                                @case('shortlisted')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        Shortlisted
                                    </span>
                                    @break
                                @case('rejected')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                        Rejected
                                    </span>
                                    @break
                                @case('hired')
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                        Hired
                                    </span>
                                    @break
                            @endswitch
                        </div>
                        <p class="text-sm text-gray-500">
                            Applied: {{ $application->applied_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
                
                @if($application->cover_letter)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <h4 class="font-medium text-gray-900 mb-2">Cover Letter</h4>
                    <p class="text-gray-700 line-clamp-3">{{ $application->cover_letter }}</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection