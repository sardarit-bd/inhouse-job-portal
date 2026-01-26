@extends('layouts.admin')

@section('title', 'Admin Management - Admin Panel')
@section('page-title', 'Admin Management')
@section('page-subtitle', 'Manage all system administrators')

@section('content')
<div x-data="adminManagement()" x-init="init()" class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Admins</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $admins->total() }}</dd>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Super Admins</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $superAdminsCount }}</dd>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Admins</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $activeAdminsCount }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Recently Added</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $recentAdminsCount }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admins List -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Admins ({{ $admins->total() }})
                    </h3>
                    <!-- <p class="mt-1 text-sm text-gray-500">
                        Manage system administrators and their permissions
                    </p> -->
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" 
                               x-model="searchQuery" 
                               @input.debounce.500ms="searchAdmins"
                               placeholder="Search admins..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500 w-64">
                        <div class="absolute left-3 top-2.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <select x-model="selectedType"
                            @change="filterByType"
                            class="w-48 border border-gray-300 rounded-md px-3 py-2 text-sm 
                                focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Types</option>
                        <option value="super" {{ request('type') == 'super' ? 'selected' : '' }}>Super Admins</option>
                        <option value="normal" {{ request('type') == 'normal' ? 'selected' : '' }}>Normal Admins</option>
                    </select>

                    <select x-model="selectedStatus"
                            @change="filterByStatus"
                            class="w-48 border border-gray-300 rounded-md px-3 py-2 text-sm 
                                focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <!-- Add Admin Button -->
                    <a href="{{ route('admin.admins.create') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Admin
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Loading State -->
        <div x-show="loading" class="p-8 text-center">
            <div class="inline-flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-600">Loading...</span>
            </div>
        </div>

        <!-- Admins Table -->
        <div x-show="!loading" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Admin
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email Verification
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($admins as $admin)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($admin->profile_photo)
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ asset('storage/' . $admin->profile_photo) }}" 
                                             alt="{{ $admin->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $admin->name }}
                                        @if($admin->id === auth()->id())
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            ME
                                        </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $admin->email }}</div>
                                    @if($admin->phone)
                                    <div class="text-sm text-gray-500">{{ $admin->phone }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($admin->is_super_admin)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <svg class="mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3"/>
                                </svg>
                                Super Admin
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <svg class="mr-1.5 h-2 w-2 text-purple-400" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3"/>
                                </svg>
                                Admin
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                @if($admin->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Active
                                </span>
                                @if($admin->id !== auth()->id())
                                <button onclick="toggleAdminStatus({{ $admin->id }}, '{{ $admin->name }}')"
                                        class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200 p-1 rounded-full hover:bg-yellow-50"
                                        title="Deactivate Admin">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </button>
                                @endif
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <svg class="mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Inactive
                                </span>
                                @if($admin->id !== auth()->id())
                                <button onclick="toggleAdminStatus({{ $admin->id }}, '{{ $admin->name }}')"
                                        class="text-green-600 hover:text-green-900 transition-colors duration-200 p-1 rounded-full hover:bg-green-50"
                                        title="Activate Admin">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </button>
                                @endif
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                @if($admin->email_verified_at)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="mr-1.5 h-4 w-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Verified
                                </span>
                                @if($admin->id !== auth()->id())
                                <button onclick="toggleEmailVerification({{ $admin->id }}, '{{ $admin->name }}', true)"
                                        class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200 p-1 rounded-full hover:bg-yellow-50"
                                        title="Mark as Unverified">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </button>
                                @endif
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="mr-1.5 h-3 w-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Unverified
                                </span>
                                @if($admin->id !== auth()->id())
                                <button onclick="toggleEmailVerification({{ $admin->id }}, '{{ $admin->name }}', false)"
                                        class="text-green-600 hover:text-green-900 transition-colors duration-200 p-1 rounded-full hover:bg-green-50"
                                        title="Mark as Verified">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </button>
                                @endif
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $admin->created_at->format('M d, Y') }}
                            <div class="text-xs text-gray-400">
                                {{ $admin->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                @if($admin->id !== auth()->id())
                                <button onclick="deleteAdmin({{ $admin->id }}, '{{ $admin->name }}')"
                                        class="text-red-600 hover:text-red-900 transition-colors duration-200 p-1 rounded-full hover:bg-red-50"
                                        title="Delete Admin">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                @else
                                <span class="text-md text-gray-700" title="You cannot delete yourself">
                                    N/A
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No admins found</h3>
                            <!-- <p class="mt-1 text-sm text-gray-500">Get started by creating a new admin.</p> -->
                            <!-- <div class="mt-6">
                                <a href="{{ route('admin.admins.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Admin
                                </a>
                            </div> -->
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($admins->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $admins->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function adminManagement() {
    return {
        loading: false,
        searchQuery: '{{ request('search') }}',
        selectedType: '{{ request('type') }}',
        selectedStatus: '{{ request('status') }}',
        
        init() {
            console.log('Admin Management Initialized');
            // Initialize Alpine.js data from URL parameters
            this.updateFromUrl();
        },
        
        updateFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            this.searchQuery = urlParams.get('search') || '';
            this.selectedType = urlParams.get('type') || '';
            this.selectedStatus = urlParams.get('status') || '';
        },
        
        async searchAdmins() {
            if (this.searchQuery.length === 0 || this.searchQuery.length >= 3) {
                await this.fetchAdmins();
            }
        },
        
        async filterByType() {
            await this.fetchAdmins();
        },
        
        async filterByStatus() {
            await this.fetchAdmins();
        },
        
        async fetchAdmins() {
            this.loading = true;
            
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.selectedType) params.append('type', this.selectedType);
                if (this.selectedStatus) params.append('status', this.selectedStatus);
                
                // Keep existing page parameter if any
                const currentPage = new URLSearchParams(window.location.search).get('page');
                if (currentPage) params.append('page', currentPage);
                
                window.location.href = `/admin/admins?${params.toString()}`;
            } catch (error) {
                console.error('Error fetching admins:', error);
            } finally {
                this.loading = false;
            }
        }
    }
}

function toggleAdminStatus(adminId, adminName) {
    const currentUserId = {{ auth()->id() }};
    if (adminId === currentUserId) {
        Swal.fire({
            title: 'Action Not Allowed',
            text: 'You cannot change your own status.',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    Swal.fire({
        title: 'Change Admin Status?',
        text: `Are you sure you want to change ${adminName}'s status?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6b7280',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/admins/${adminId}/toggle-status`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function toggleEmailVerification(adminId, adminName, isVerified) {
    const currentUserId = {{ auth()->id() }};
    if (adminId === currentUserId) {
        Swal.fire({
            title: 'Action Not Allowed',
            text: 'You cannot change your own verification status.',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    const action = isVerified ? 'unverify' : 'verify';
    const actionText = isVerified ? 'Unverify' : 'Verify';
    
    Swal.fire({
        title: `${actionText} Email?`,
        text: `Are you sure you want to ${action} ${adminName}'s email verification?`,
        icon: isVerified ? 'warning' : 'info',
        showCancelButton: true,
        confirmButtonText: `Yes, ${actionText}!`,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6b7280',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/admins/${adminId}/toggle-email-verification`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function deleteAdmin(adminId, adminName) {
    const currentUserId = {{ auth()->id() }};
    if (adminId === currentUserId) {
        Swal.fire({
            title: 'Action Not Allowed',
            text: 'You cannot delete yourself.',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    Swal.fire({
        title: 'Delete Admin?',
        text: `Are you sure you want to delete ${adminName}? This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/admins/${adminId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush

@push('styles')
<style>
[x-cloak] {
    display: none !important;
}

/* Better alignment for status and verification columns */
.flex.items-center.space-x-2 {
    align-items: center;
}

/* Better button styling for hover effect */
button.p-1.rounded-full {
    padding: 0.25rem;
    border-radius: 9999px;
}

button.p-1.rounded-full:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

/* Ensure select dropdowns show current filter */
select option[selected] {
    font-weight: bold;
}
</style>
@endpush