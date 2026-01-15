@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- LEFT : LOGIN FORM -->
    <div class="flex items-center justify-center px-6 lg:px-16 bg-white">
        <div class="w-full max-w-md">

            <!-- Logo -->
            <!-- <a href="{{ route('home') }}" class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-teal-700 rounded-lg flex items-center justify-center text-white font-bold">
                    {}
                </div>
                <span class="text-xl font-semibold text-gray-900">SoftQA</span>
            </a> -->

            <h2 class="text-3xl text-center font-semibold text-gray-900 mb-2">
                Sign in
            </h2>
            <!-- <p class="text-gray-500 mb-8">
                Sign in to access your dashboard and continue optimizing your QA process.
            </p> -->

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <!-- <label class="block text-sm font-medium text-gray-700 mb-1">Email</label> -->
                    <div class="relative">
                        <input type="email" name="email" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-teal-600 focus:outline-none"
                            placeholder="Enter your email"
                            value="{{ old('email') }}">
                    </div>
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Password -->
                <div>
                    <!-- <label class="block text-sm font-medium text-gray-700 mb-1">Password</label> -->
                    <input type="password" name="password" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-teal-600 focus:outline-none"
                        placeholder="Enter your password">
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-blue-700 hover:underline">
                        Forgot Password?
                    </a>
                </div>

                <!-- Button -->
                <button
                    class="w-full bg-blue-800 hover:bg-blue-900 text-white py-3 rounded-lg font-medium transition">
                    Sign In
                </button>

                <!-- Divider -->
                <!-- <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t"></div>
                    </div>
                    <div class="relative text-center text-sm text-gray-500 bg-white px-2">
                        OR
                    </div>
                </div> -->

                <!-- Social -->
                <!-- <div class="space-y-3">
                    <button class="w-full border rounded-lg py-3 flex items-center justify-center gap-3">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5">
                        Continue with Google
                    </button>
                    <button class="w-full border rounded-lg py-3 flex items-center justify-center gap-3">
                        <svg class="w-5" viewBox="0 0 24 24" fill="black">
                            <path d="M16.365 1.43c0 1.14-.45 2.29-1.28 3.18-.88.96-2.2 1.7-3.44 1.6-.12-1.15.45-2.35 1.25-3.19.88-.99 2.34-1.72 3.47-1.59z"/>
                        </svg>
                        Continue with Apple
                    </button>
                </div> -->

                <p class="text-center text-sm text-gray-600 mt-6">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-blue-700 font-medium">Sign Up</a>
                </p>
            </form>
        </div>
    </div>

    <!-- RIGHT : MARKETING PANEL -->
    <div class="hidden lg:flex relative flex-col justify-between px-16 py-20 text-white">

        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80"
                alt="Job Portal Career Background"
                class="w-full h-full object-cover">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-100/70 to-blue-200/50 backdrop-blur-sm"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10">
            <h2 class="text-4xl font-semibold leading-tight mb-6">
                Find Your Dream Job,<br>
                Build Your Career with Confidence
            </h2>

            <p class="text-lg text-indigo-100 max-w-md">
                Discover thousands of verified job opportunities from trusted companies.
                Apply smarter and get hired faster.
            </p>

            <!-- Testimonial -->
            <div class="mt-10">
                <p class="italic text-indigo-100 mb-6 max-w-lg">
                    “This platform helped us connect with top talent quickly.
                    Hiring has never been this smooth.”
                </p>

                <div class="flex items-center gap-4">
                    <img src="https://i.pravatar.cc/80?img=32"
                        class="w-12 h-12 rounded-full border border-white/30">
                    <div>
                        <p class="font-medium">Arif Hasan</p>
                        <p class="text-sm text-indigo-200">
                            HR Lead at NexaTech
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Logos -->
        <div class="relative z-10 opacity-90">
            <p class="text-sm mb-4 uppercase tracking-wide">
                Trusted by 1000+ Companies
            </p>

            <div class="flex flex-wrap gap-6 text-indigo-200 text-sm font-medium">
                <span>Google</span>
                <span>Microsoft</span>
                <span>Amazon</span>
                <span>Netflix</span>
                <span>Shopify</span>
            </div>
        </div>
    </div>
</div>
@endsection
