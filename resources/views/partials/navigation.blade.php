<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">JobPortal</span>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:ml-10 md:flex md:space-x-8">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        Home
                    </x-nav-link>
                    <x-nav-link href="{{ route('jobs.index') }}" :active="request()->routeIs('jobs.*')">
                        Browse Jobs
                    </x-nav-link>
                    <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">
                        About
                    </x-nav-link>
                    <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">
                        Contact
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center">
                <!-- Search (Desktop) -->
                <div class="hidden md:block mr-4">
                    <form action="{{ route('jobs.index') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="Search jobs..." 
                               class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </form>
                </div>

                <!-- Auth Links -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="text-gray-700 font-medium hidden lg:inline">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-500" :class="{ 'transform rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        Admin Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('job-seeker.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('job-seeker.profile.edit') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        My Profile
                                    </a>
                                @endif
                                <div class="border-t border-gray-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:from-indigo-700 hover:to-purple-700 transition duration-300">
                            Sign Up
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t border-gray-200">
        <div class="px-4 py-3 space-y-3">
            <!-- Search Mobile -->
            <form action="{{ route('jobs.index') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Search jobs..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>

            <!-- Mobile Links -->
            <div class="space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('home') ? 'bg-gray-100 text-indigo-600' : '' }}">
                    Home
                </a>
                <a href="{{ route('jobs.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('jobs.*') ? 'bg-gray-100 text-indigo-600' : '' }}">
                    Browse Jobs
                </a>
                <a href="{{ route('about') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('about') ? 'bg-gray-100 text-indigo-600' : '' }}">
                    About
                </a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg {{ request()->routeIs('contact') ? 'bg-gray-100 text-indigo-600' : '' }}">
                    Contact
                </a>
                
                @auth
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                                Admin Dashboard
                            </a>
                        @else
                            <a href="{{ route('job-seeker.dashboard') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                                Dashboard
                            </a>
                            <a href="{{ route('job-seeker.profile.edit') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                                My Profile
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>