@extends('layouts.admin')

@section('page-title', 'Notifications')

@section('content')
<div class="mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800"></h2>
                
                <div class="flex space-x-3">
                    @if(Auth::user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Mark All as Read
                        </button>
                    </form>
                    @endif
                    
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($notifications as $notification)
            <div class="px-6 py-4 hover:bg-gray-50 {{ !$notification->read_at ? 'bg-blue-50' : '' }}">
                <div class="flex items-center">
                    <div class="flex-shrink-0 mt-1">
                        <div class="h-10 w-10 rounded-full {{ !$notification->read_at ? 'bg-blue-100' : 'bg-gray-100' }} flex items-center justify-center">
                            <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} {{ !$notification->read_at ? 'text-blue-600' : 'text-gray-400' }}"></i>
                        </div>
                    </div>
                    
                    <div class="ml-4 flex-1">
                        <div class="flex justify-between">
                            <div>
                                <!-- <a href="{{ route('notifications.show', $notification->id) }}" 
                                   class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </a> -->

                                <a href="{{ route('notifications.show', $notification->id) }}" 
                                   class="text-md font-medium text-gray-900 hover:text-blue-600">
                                    {{ $notification->data['message'] ?? '' }}
                                </a>

                                
                                <!-- <p class="text-md text-gray-600">
                                    {{ $notification->data['message'] ?? '' }}
                                </p> -->
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                
                                <div class="flex items-center space-x-2">
                                    @if(!$notification->read_at)
                                    <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                                    @endif
                                    
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-gray-400 hover:text-red-600">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <i class="fas fa-bell-slash text-gray-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700">No notifications</h3>
                <!-- <p class="mt-1 text-gray-500">You don't have any notifications yet.</p> -->
            </div>
            @endforelse
        </div>
        
        @if($notifications->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto refresh notification count every 30 seconds
setInterval(function() {
    fetch('{{ route("notifications.unreadCount") }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        });
}, 30000);
</script>
@endsection