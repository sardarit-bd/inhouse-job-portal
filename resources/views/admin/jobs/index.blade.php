@extends('layouts.admin')

@section('title', 'Jobs - Admin Panel')
@section('page-title', 'Job Management')
@section('page-subtitle', 'Manage all job postings')

@push('styles')
<style>
    /* Fix for filter dropdown overflow */
    .filter-dropdown-container {
        position: relative;
    }
    
    .filter-dropdown-menu {
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 0.5rem;
        z-index: 50;
        width: 320px;
        max-height: 70vh;
        overflow-y: auto;
    }
    
    /* Compact filter options */
    .filter-option {
        display: flex;
        align-items: center;
        padding: 0.5rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .filter-option:hover {
        background-color: #f9fafb;
    }
    
    .filter-option.selected {
        background-color: #eff6ff;
    }
    
    .filter-section {
        margin-bottom: 1rem;
    }
    
    .filter-section:last-child {
        margin-bottom: 0;
    }
    
    .selected-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .filter-tag {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        background-color: #dbeafe;
        color: #1e40af;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .filter-tag button {
        margin-left: 0.25rem;
        color: #93c5fd;
        background: none;
        border: none;
        cursor: pointer;
    }
    
    .filter-tag button:hover {
        color: #3b82f6;
    }
    
    .filter-input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }
    
    .filter-input:focus {
        outline: none;
        ring: 2px;
        ring-color: #3b82f6;
        border-color: #3b82f6;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-5">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Jobs</dt>
                            <dd class="text-lg font-semibold text-gray-900" id="total-jobs">{{ $totalJobs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Approval</dt>
                            <dd class="text-lg font-semibold text-gray-900" id="pending-jobs">{{ $pendingJobs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 01118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Jobs</dt>
                            <dd class="text-lg font-semibold text-gray-900" id="active-jobs">{{ $activeJobs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Available Jobs</dt>
                            <dd class="text-lg font-semibold text-gray-900" id="available-jobs">{{ $availableJobs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Expired Jobs</dt>
                            <dd class="text-lg font-semibold text-gray-900" id="expired-jobs">{{ $expiredJobs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs List -->
    <div class="bg-white shadow rounded-lg overflow-visible">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        All Jobs (<span id="total-jobs-count">{{ $jobs->total() }}</span>)
                    </h3>
                    <p class="mt-1 text-sm text-gray-500" id="filter-status">
                        Showing {{ $jobs->firstItem() ?? 0 }}-{{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search jobs..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
                               id="search-input"
                               value="{{ request('search') }}">
                        <div class="absolute left-3 top-2.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Filter Dropdown -->
                    <div class="relative filter-dropdown-container">
                        <button type="button" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                id="filter-dropdown-btn">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter
                            <span class="ml-2 text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full" id="filter-count">
                                @php
                                    $filterCount = 0;
                                    if(request('status')) $filterCount++;
                                    if(request('job_type')) $filterCount++;
                                    if(request('experience_level')) $filterCount++;
                                    if(request('is_active') !== null) $filterCount++;
                                    if(request('date_status')) $filterCount++;
                                @endphp
                                {{ $filterCount }}
                            </span>
                        </button>
                        
                        <!-- Filter Dropdown Menu -->
                        <div class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg border border-gray-200 z-50 filter-dropdown-menu" 
                             id="filter-dropdown-menu">
                            <div class="p-4 space-y-4">
                                <!-- Selected Filters Display -->
                                <div id="selected-filters-display" class="selected-filters">
                                    <!-- Selected filters will be added here by JavaScript -->
                                </div>
                                
                                <!-- Status Filter -->
                                <div class="filter-section">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Job Status</label>
                                    <div class="space-y-1 max-h-40 overflow-y-auto">
                                        @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $value => $label)
                                            <div class="filter-option" data-type="status" data-value="{{ $value }}">
                                                <input type="checkbox" 
                                                       id="status-{{ $value }}"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                       {{ request('status') == $value ? 'checked' : '' }}>
                                                <label for="status-{{ $value }}" class="ml-2 text-sm text-gray-700 cursor-pointer">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Job Type Filter -->
                                <div class="filter-section">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Job Type</label>
                                    <div class="space-y-1 max-h-40 overflow-y-auto">
                                        @foreach(['full-time' => 'Full Time', 'part-time' => 'Part Time', 'contract' => 'Contract', 'remote' => 'Remote', 'internship' => 'Internship'] as $value => $label)
                                            <div class="filter-option" data-type="job_type" data-value="{{ $value }}">
                                                <input type="checkbox" 
                                                       id="type-{{ $value }}"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                       {{ request('job_type') == $value ? 'checked' : '' }}>
                                                <label for="type-{{ $value }}" class="ml-2 text-sm text-gray-700 cursor-pointer">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Active Status Filter -->
                                <div class="filter-section">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Active Status</label>
                                    <div class="flex space-x-4">
                                        <div class="filter-option" data-type="is_active" data-value="1">
                                            <input type="radio" 
                                                   name="is_active" 
                                                   id="active-1"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                   {{ request('is_active') === '1' ? 'checked' : '' }}>
                                            <label for="active-1" class="ml-2 text-sm text-gray-700 cursor-pointer">Active</label>
                                        </div>
                                        <div class="filter-option" data-type="is_active" data-value="0">
                                            <input type="radio" 
                                                   name="is_active" 
                                                   id="active-0"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                   {{ request('is_active') === '0' ? 'checked' : '' }}>
                                            <label for="active-0" class="ml-2 text-sm text-gray-700 cursor-pointer">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Date Status Filter -->
                                <div class="filter-section">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Status</label>
                                    <div class="flex space-x-4">
                                        <div class="filter-option" data-type="date_status" data-value="available">
                                            <input type="radio" 
                                                   name="date_status" 
                                                   id="date-available"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                   {{ request('date_status') == 'available' ? 'checked' : '' }}>
                                            <label for="date-available" class="ml-2 text-sm text-gray-700 cursor-pointer">Available</label>
                                        </div>
                                        <div class="filter-option" data-type="date_status" data-value="expired">
                                            <input type="radio" 
                                                   name="date_status" 
                                                   id="date-expired"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                   {{ request('date_status') == 'expired' ? 'checked' : '' }}>
                                            <label for="date-expired" class="ml-2 text-sm text-gray-700 cursor-pointer">Expired</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Filter Actions -->
                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex justify-between">
                                        <button type="button" 
                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                                id="clear-filters">
                                            Clear All
                                        </button>
                                        <button type="button" 
                                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                id="apply-filters">
                                            Apply Filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.jobs.index') }}" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Reset
                    </a>
                    
                    <a href="{{ route('admin.jobs.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Post Job
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Loading Indicator -->
        <div id="loading-indicator" class="hidden">
            <div class="flex justify-center items-center p-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <span class="ml-3 text-gray-600">Loading jobs...</span>
            </div>
        </div>
        
        <!-- Jobs Table Container -->
        <div id="jobs-table-container">
            @include('admin.jobs.partials.jobs_table', ['jobs' => $jobs])
        </div>
    </div>
</div>

<!-- Update Status Form -->
<form id="status-form" method="POST" style="display: none;">
    @csrf
    @method('POST')
    <input type="hidden" name="status" id="status-input">
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Current filters state
let currentFilters = {
    status: "{{ request('status') }}",
    job_type: "{{ request('job_type') }}",
    experience_level: "{{ request('experience_level') }}",
    is_active: "{{ request('is_active') }}",
    date_status: "{{ request('date_status') }}"
};

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Update selected filters display
function updateSelectedFiltersDisplay() {
    const container = document.getElementById('selected-filters-display');
    container.innerHTML = '';
    
    let filterCount = 0;
    
    // Status filter
    if (currentFilters.status) {
        const statusLabel = getStatusLabel(currentFilters.status);
        container.innerHTML += createFilterTag('status', currentFilters.status, statusLabel);
        filterCount++;
    }
    
    // Job type filter
    if (currentFilters.job_type) {
        const jobTypeLabel = getJobTypeLabel(currentFilters.job_type);
        container.innerHTML += createFilterTag('job_type', currentFilters.job_type, jobTypeLabel);
        filterCount++;
    }
    
    // Experience level filter
    if (currentFilters.experience_level) {
        const expLabel = getExperienceLabel(currentFilters.experience_level);
        container.innerHTML += createFilterTag('experience_level', currentFilters.experience_level, expLabel);
        filterCount++;
    }
    
    // Active status filter
    if (currentFilters.is_active !== '') {
        const activeLabel = currentFilters.is_active === '1' ? 'Active' : 'Inactive';
        container.innerHTML += createFilterTag('is_active', currentFilters.is_active, activeLabel);
        filterCount++;
    }
    
    // Date status filter
    if (currentFilters.date_status) {
        const dateLabel = getDateStatusLabel(currentFilters.date_status);
        container.innerHTML += createFilterTag('date_status', currentFilters.date_status, dateLabel);
        filterCount++;
    }
    
    // Update filter count badge
    document.getElementById('filter-count').textContent = filterCount;
}

// Create filter tag HTML
function createFilterTag(type, value, label) {
    return `
        <div class="filter-tag">
            ${label}
            <button type="button" onclick="removeFilter('${type}')">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;
}

// Get status label
function getStatusLabel(value) {
    const labels = {
        'pending': 'Pending',
        'approved': 'Approved',
        'rejected': 'Rejected'
    };
    return labels[value] || value;
}

// Get job type label
function getJobTypeLabel(value) {
    const labels = {
        'full-time': 'Full Time',
        'part-time': 'Part Time',
        'contract': 'Contract',
        'remote': 'Remote',
        'internship': 'Internship'
    };
    return labels[value] || value;
}

// Get experience label
function getExperienceLabel(value) {
    const labels = {
        'intern': 'Intern',
        'junior': 'Junior',
        'mid': 'Mid Level',
        'senior': 'Senior',
        'lead': 'Lead',
        'executive': 'Executive'
    };
    return labels[value] || value;
}

// Get date status label
function getDateStatusLabel(value) {
    const labels = {
        'available': 'Available',
        'expired': 'Expired',
        'no_deadline': 'No Deadline'
    };
    return labels[value] || value;
}

// Remove a filter
function removeFilter(type) {
    currentFilters[type] = '';
    
    // Uncheck corresponding checkbox/radio
    if (type === 'status' || type === 'job_type' || type === 'experience_level') {
        const checkboxes = document.querySelectorAll(`input[type="checkbox"][name^="${type}"]`);
        checkboxes.forEach(cb => cb.checked = false);
    } else if (type === 'is_active' || type === 'date_status') {
        const radios = document.querySelectorAll(`input[type="radio"][name="${type}"]`);
        radios.forEach(radio => radio.checked = false);
    }
    
    updateSelectedFiltersDisplay();
    loadJobs();
}

// Load jobs with AJAX
function loadJobs(page = 1) {
    const search = document.getElementById('search-input').value;
    
    const params = new URLSearchParams();
    
    if (search) params.set('search', search);
    if (currentFilters.status) params.set('status', currentFilters.status);
    if (currentFilters.job_type) params.set('job_type', currentFilters.job_type);
    if (currentFilters.experience_level) params.set('experience_level', currentFilters.experience_level);
    if (currentFilters.date_status) params.set('date_status', currentFilters.date_status);
    if (currentFilters.is_active !== '') params.set('is_active', currentFilters.is_active);
    if (page > 1) params.set('page', page);
    
    // Show loading indicator
    document.getElementById('loading-indicator').classList.remove('hidden');
    document.getElementById('jobs-table-container').classList.add('opacity-50');
    
    fetch(`{{ route('admin.jobs.index') }}?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update jobs table
        document.getElementById('jobs-table-container').innerHTML = data.html;
        
        // Update stats
        if (data.stats) {
            document.getElementById('total-jobs').textContent = data.stats.totalJobs;
            document.getElementById('pending-jobs').textContent = data.stats.pendingJobs;
            document.getElementById('active-jobs').textContent = data.stats.activeJobs;
            document.getElementById('available-jobs').textContent = data.stats.availableJobs;
            document.getElementById('expired-jobs').textContent = data.stats.expiredJobs;
            document.getElementById('total-jobs-count').textContent = data.stats.currentTotal;
        }
        
        // Update filter status
        const showingText = `Showing ${data.jobs.from || 0}-${data.jobs.to || 0} of ${data.jobs.total} jobs`;
        document.getElementById('filter-status').textContent = showingText;
        
        // Update URL without reloading page
        const url = new URL(window.location.href);
        url.search = params.toString();
        window.history.replaceState({}, '', url);
        
        // Hide loading indicator
        document.getElementById('loading-indicator').classList.add('hidden');
        document.getElementById('jobs-table-container').classList.remove('opacity-50');
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('loading-indicator').classList.add('hidden');
        document.getElementById('jobs-table-container').classList.remove('opacity-50');
    });
}

// Update job status with AJAX
function updateJobStatus(jobId, status, title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/jobs/${jobId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload jobs after status update
                    loadJobs();
                    Swal.fire('Success!', data.message, 'success');
                } else {
                    Swal.fire('Error!', data.message || 'Something went wrong', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Failed to update job status', 'error');
            });
        }
    });
}

function confirmDelete(jobId, jobTitle) {
    Swal.fire({
        title: 'Delete Job',
        html: `Are you sure you want to delete <strong>${jobTitle}</strong>?<br><span class="text-sm text-red-600">This action cannot be undone!</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${jobId}`).submit();
        }
    });
}

// Filter dropdown toggle
document.getElementById('filter-dropdown-btn').addEventListener('click', function() {
    const menu = document.getElementById('filter-dropdown-menu');
    menu.classList.toggle('hidden');
});

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdownBtn = document.getElementById('filter-dropdown-btn');
    const dropdownMenu = document.getElementById('filter-dropdown-menu');
    
    if (!dropdownBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.classList.add('hidden');
    }
});

// Handle checkbox changes for status and job_type filters
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const parent = this.closest('.filter-option');
        const type = parent.dataset.type;
        const value = parent.dataset.value;
        
        if (this.checked) {
            currentFilters[type] = value;
        } else {
            currentFilters[type] = '';
        }
        
        updateSelectedFiltersDisplay();
    });
});

// Handle radio button changes
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const parent = this.closest('.filter-option');
        const type = parent.dataset.type;
        const value = parent.dataset.value;
        
        currentFilters[type] = value;
        updateSelectedFiltersDisplay();
    });
});

// Initialize filters display on page load
document.addEventListener('DOMContentLoaded', function() {
    updateSelectedFiltersDisplay();
    
    // Set up AJAX for status update form submission
    const statusForm = document.getElementById('status-form');
    if (statusForm) {
        statusForm.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }
    
    // Apply filters button
    document.getElementById('apply-filters').addEventListener('click', function() {
        // Close dropdown
        document.getElementById('filter-dropdown-menu').classList.add('hidden');
        // Load jobs with current filters
        loadJobs();
    });
    
    // Clear filters button
    document.getElementById('clear-filters').addEventListener('click', function() {
        // Reset all filters
        currentFilters = {
            status: '',
            job_type: '',
            experience_level: '',
            is_active: '',
            date_status: ''
        };
        
        // Uncheck all checkboxes and radios
        document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        document.querySelectorAll('input[type="radio"]').forEach(radio => radio.checked = false);
        
        // Clear search input
        document.getElementById('search-input').value = '';
        
        updateSelectedFiltersDisplay();
        loadJobs();
    });
});

// Update filter count when radio buttons change
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        updateSelectedFiltersDisplay();
    });
});

// Search with debounce
const debouncedSearch = debounce(() => {
    loadJobs();
}, 500);

document.getElementById('search-input').addEventListener('keyup', debouncedSearch);

// Handle pagination clicks
document.addEventListener('click', function(e) {
    if (e.target.matches('.pagination a') || e.target.closest('.pagination a')) {
        e.preventDefault();
        const url = new URL(e.target.href || e.target.closest('a').href);
        const page = url.searchParams.get('page') || 1;
        loadJobs(page);
    }
});
</script>
@endpush
@endsection