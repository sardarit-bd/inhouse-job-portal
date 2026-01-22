<!-- resources/views/layouts/partials/admin-header.blade.php -->
<header class="bg-white shadow-lg border-b border-gray-200">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Left side: Page title -->
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-gray-900 hidden lg:block">
                    @yield('page-title', 'Dashboard')
                </h1>
            </div>
            
            <!-- Right side: User menu and notifications -->
            <div class="flex items-center space-x-4">
                <!-- Notifications Dropdown -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" 
                            class="p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none relative">
                        <span class="sr-only">View notifications</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        
                        @if($notificationCount > 0)
                        <span class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">
                            {{ $notificationCount > 9 ? '9+' : $notificationCount }}
                        </span>
                        @endif
                    </button>
                    
                    <!-- Notifications Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="origin-top-right absolute right-0 mt-2 w-96 rounded-lg shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 border border-gray-200"
                         style="display: none;">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex justify-between items-center">
                                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                @if($notificationCount > 0)
                                <form action="{{ route('notifications.markAllAsRead') }}" 
                                      method="POST" 
                                      id="markAllAsReadForm">
                                    @csrf
                                    <button type="submit" 
                                            class="text-xs text-blue-600 hover:text-blue-800 focus:outline-none">
                                        Mark all as read
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        
                        <div class="max-h-96 overflow-y-auto" id="notification-list">
                            @if($notifications->count() > 0)
                                @foreach($notifications as $notification)
                                <a href="{{ route('notifications.show', $notification->id) }}" 
                                   class="block px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-150 {{ !$notification->read_at ? 'bg-blue-50' : '' }}">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full {{ !$notification->read_at ? 'bg-blue-100' : 'bg-gray-100' }} flex items-center justify-center">
                                                <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} {{ !$notification->read_at ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $notification->data['title'] ?? 'Notification' }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $notification->data['message'] ?? '' }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        @if(!$notification->read_at)
                                        <div class="flex-shrink-0 ml-2">
                                            <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                                        </div>
                                        @endif
                                    </div>
                                </a>
                                @endforeach
                            @else
                                <div class="px-4 py-8 text-center">
                                    <i class="fas fa-bell-slash text-gray-300 text-3xl mb-2"></i>
                                    <p class="text-sm text-gray-500">No notifications</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="border-t border-gray-100">
                            <a href="{{ route('notifications.index') }}" 
                               class="block px-4 py-3 text-sm text-center text-blue-600 hover:bg-blue-50 font-medium">
                                View all notifications
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- User dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-md">
                                <span class="text-white font-bold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <div class="hidden lg:block text-left">
                            <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <!-- Dropdown menu -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 border border-gray-200"
                         style="display: none;">
                        
                        <a href="{{ route('admin.dashboard') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            <svg class="inline-block w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            <svg class="inline-block w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            </svg>
                            Profile Settings
                        </a>
                        
                        <div class="border-t border-gray-100"></div>
                        
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700">
                                <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
// Mark all as read with AJAX
document.getElementById('markAllAsReadForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload notifications list
            location.reload();
        }
    });
});

// Auto refresh notifications every 30 seconds
setInterval(function() {
    fetch('{{ route("notifications.unread") }}')
        .then(response => response.json())
        .then(notifications => {
            const notificationList = document.getElementById('notification-list');
            const badge = document.querySelector('.notification-badge');
            
            if (notifications.length > 0 && notificationList) {
                // Update badge count
                if (badge) {
                    badge.textContent = notifications.length > 9 ? '9+' : notifications.length;
                    badge.classList.remove('hidden');
                }
                
                // You can update the notification list dynamically here
                // For simplicity, we'll just reload the dropdown
                window.dispatchEvent(new Event('notification-update'));
            } else {
                if (badge) {
                    badge.classList.add('hidden');
                }
            }
        });
}, 30000);
</script>