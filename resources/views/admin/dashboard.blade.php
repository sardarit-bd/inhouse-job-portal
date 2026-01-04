<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Jobs</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_jobs'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Jobs</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_jobs'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Applications</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_applications'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.667.916-1.583 1.5-2.6 1.5h-1.3c-1.02 0-1.9-.592-2.6-1.5" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Hires</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_hires'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Jobs & Applications -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Jobs -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Job Postings</h3>
                <p class="mt-1 text-sm text-gray-500">Recently posted jobs requiring approval</p>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($recentJobs as $job)
                <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">{{ $job->title }}</h4>
                            <p class="text-sm text-gray-500">{{ $job->company_name }} • {{ $job->location }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $job->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($job->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($job->status) }}
                            </span>
                            <a href="{{ route('admin.jobs.show', $job) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Recent Applications -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Applications</h3>
                <p class="mt-1 text-sm text-gray-500">Latest job applications</p>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($recentApplications as $application)
                <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">{{ $application->user->name }}</h4>
                            <p class="text-sm text-gray-500">Applied for {{ $application->job->title }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $application->status === 'hired' ? 'bg-green-100 text-green-800' : 
                                   ($application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($application->status === 'shortlisted' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                {{ ucfirst($application->status) }}
                            </span>
                            <a href="{{ route('admin.applications.show', $application) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection