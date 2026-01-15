@extends('layouts.guest')

@section('title', 'Register - JobPortal')

@section('content')
<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- LEFT : FULL IMAGE BACKGROUND -->
    <div class="hidden lg:flex relative items-center justify-center text-white">

        <!-- Background Image -->
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Career Growth Background"
                class="w-full h-full object-cover"
            >
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-100/70 to-blue-200/50 backdrop-blur-sm"></div>

        </div>

        <!-- Content -->
        <div class="relative z-10 px-16">
            <h2 class="text-4xl text-blue-800 font-semibold leading-tight mb-6">
                Start Your Career Journey<br>
                With the Right Opportunity
            </h2>

            <p class="text-lg text-blue-500 max-w-md mb-10">
                Join thousands of job seekers who found their dream jobs.
                Build your profile, apply confidently, and get hired faster.
            </p>

            <!-- Quote -->
            <div class="flex items-center gap-4">
                <img src="https://i.pravatar.cc/80?img=45"
                     class="w-12 h-12 rounded-full border border-white/30">
                <div>
                    <p class="font-medium">Nusrat Jahan</p>
                    <p class="text-sm text-blue-200">
                        Software Engineer
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT : REGISTER FORM -->
    <div class="flex items-center justify-center bg-white py-12 px-6 lg:px-16">
        <div class="w-full max-w-md space-y-8">

            <!-- Header -->
            <div class="text-center">
                <!-- <a href="{{ route('home') }}" class="inline-flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">JobPortal</span>
                </a> -->

                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Sign Up
                </h2>

                
            </div>

            <!-- FORM -->
            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Full Name -->
                <div>
                    <input id="name" name="name" type="text" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                           placeholder="Full Name"
                           value="{{ old('name') }}">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <input id="email" name="email" type="email" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                           placeholder="Email address"
                           value="{{ old('email') }}">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div>
                    <input id="phone" name="phone" type="tel"
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                           placeholder="Phone Number (Optional)"
                           value="{{ old('phone') }}">
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="relative">
                    <input id="password" name="password" type="password" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                           placeholder="Password">
                    <button type="button" onclick="togglePassword('password')"
                            class="absolute right-3 top-3 text-gray-400">
                        <svg id="password-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500"
                           placeholder="Confirm Password">
                    <button type="button" onclick="togglePassword('password_confirmation')"
                            class="absolute right-3 top-3 text-gray-400">
                        <svg id="confirm-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Terms -->
                <div class="flex items-start">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="terms" class="ml-2 text-sm text-gray-900">
                        I agree to the
                        <a href="#" class="text-blue-600">Terms</a> &
                        <a href="#" class="text-blue-600">Privacy Policy</a>
                    </label>
                </div>

                <!-- Info -->
                <!-- <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-700">
                    You are registering as a <strong>Job Seeker</strong>.
                    Only administrators can post jobs.
                </div> -->

                <!-- Submit -->
                <button type="submit"
                        class="w-full py-3 rounded-xl text-white font-medium
                               bg-gradient-to-r from-blue-600 to-purple-600
                               hover:from-blue-700 hover:to-purple-700 transition">
                    Create Job Seeker Account
                </button>

                <p class="mt-2 text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Sign in here
                    </a>
                </p>
            </form>
        </div>
    </div>

</div>

<script>
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId === 'password' ? 'password-eye' : 'confirm-eye');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        `;
    } else {
        input.type = 'password';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}
</script>
@endsection
