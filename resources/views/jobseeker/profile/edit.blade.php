@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('job-seeker.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a></li>
            <li><span class="mx-2">›</span></li>
            <li class="text-gray-800 font-medium">Edit Profile</li>
        </ol>
    </nav>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <!-- <p class="text-red-700 font-medium">Please fix the following errors:</p> -->
                    <ul class="mt-2 text-red-600 list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Layout -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Left Sidebar - Navigation -->
        <div class="lg:w-64 flex-shrink-0">
            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <!-- Profile Photo -->
                <div class="text-center mb-6">
                    <div class="relative inline-block">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                 alt="Profile Photo" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md mx-auto"
                                 id="profilePhotoPreview">
                        @else
                            <div 
                                class="w-50 h-32 mx-auto rounded-md border-2 border-dashed border-gray-300 
                                    flex flex-col items-center justify-center text-center 
                                    text-gray-400 bg-gray-50">

                                <svg class="w- h-8 mb-1" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 16v-8m0 0l-3 3m3-3l3 3M20 16.5a4.5 4.5 0 00-3.5-4.37
                                            6 6 0 10-8.99 0A4.5 4.5 0 004 16.5" />
                                </svg>

                                <span class="text-xs font-medium">Upload Photo</span>
                            </div>
                        @endif

                        
                        <!-- Photo Upload Indicator -->
                        <div id="uploadProgress" class="hidden absolute inset-0 bg-blue-500 bg-opacity-75 rounded-full flex items-center justify-center">
                            <i class="fas fa-spinner fa-spin text-white text-2xl"></i>
                        </div>
                    </div>
                    
                    <h3 class="mt-3 font-medium text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $jobSeekerProfile->title ?? 'Job Seeker' }}</p>
                </div>
                
                <!-- Photo Upload Section -->
                <div class="space-y-3">
                    <form id="photoUploadForm" action="{{ route('job-seeker.profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
                    </form>
                    
                    <button onclick="document.getElementById('profile_photo').click()" 
                            class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-camera mr-2"></i>
                        Upload Photo
                    </button>
                    
                    @if($user->profile_photo)
                    <button onclick="confirmDeletePhoto()"
                            class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        <i class="fas fa-trash mr-2"></i>
                        Remove Photo
                    </button>
                    @endif
                    
                    <div class="text-xs text-gray-400 text-center pt-2 border-t border-gray-100">
                        <p>JPG, PNG or GIF • Max 2MB</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <nav class="p-4">
                    <ul class="space-y-1">
                        <li>
                            <button onclick="showSection('basic-profile')" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center transition-colors bg-blue-50 text-blue-700 font-medium">
                                <span class="w-1 h-6 bg-blue-600 rounded-full mr-3"></span>
                                <i class="fas fa-user-circle mr-2"></i>
                                Profile Info
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('education')" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="w-1 h-6 bg-transparent rounded-full mr-3"></span>
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Education
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('skills')" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="w-1 h-6 bg-transparent rounded-full mr-3"></span>
                                <i class="fas fa-tools mr-2"></i>
                                Skills
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('experience')" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="w-1 h-6 bg-transparent rounded-full mr-3"></span>
                                <i class="fas fa-briefcase mr-2"></i>
                                Experience
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('projects')" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="w-1 h-6 bg-transparent rounded-full mr-3"></span>
                                <i class="fas fa-project-diagram mr-2"></i>
                                Projects
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('certifications')" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="w-1 h-6 bg-transparent rounded-full mr-3"></span>
                                <i class="fas fa-certificate mr-2"></i>
                                Certifications
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('social-links')" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="w-1 h-6 bg-transparent rounded-full mr-3"></span>
                                <i class="fas fa-share-alt mr-2"></i>
                                Social Links
                            </button>
                        </li>
                        <li>
                            <button onclick="showSection('visibility')" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                <span class="w-1 h-6 bg-transparent rounded-full mr-3"></span>
                                <i class="fas fa-eye mr-2"></i>
                                Visibility
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <!-- Profile Completion -->
            @php
                $totalFields = 10;
                $completedFields = 0;
                if($user->name) $completedFields++;
                if($personalInfo->first_name || $personalInfo->last_name) $completedFields++;
                if($personalInfo->phone || $user->phone) $completedFields++;
                if($personalInfo->address || $user->address) $completedFields++;
                if($jobSeekerProfile->title) $completedFields++;
                if($jobSeekerProfile->summary) $completedFields++;
                if($jobSeekerProfile->experience_level) $completedFields++;
                if($educations->count() > 0) $completedFields++;
                if($skills->count() > 0) $completedFields++;
                if($experiences->count() > 0) $completedFields++;
                $completionPercentage = ($completedFields / $totalFields) * 100;
            @endphp
            
            <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Profile Completion</h4>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $completionPercentage }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ round($completionPercentage) }}% Complete • {{ $completedFields }}/{{ $totalFields }} fields</p>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1">
            <!-- All sections are initially shown, JavaScript will hide/show them -->
            
            <!-- Basic Profile Information -->
            <div id="basic-profile" class="section active">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">Profile Information</h2>
                        <p class="text-sm text-gray-600 mt-1">Update your personal and professional information</p>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('job-seeker.profile.complete-update') }}" method="POST">
                            @csrf
                            
                            <div class="space-y-6">
                                <!-- Personal Details -->
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Personal Details</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Display Name *</label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                            <input type="text" name="first_name" value="{{ old('first_name', $personalInfo->first_name ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                            <input type="text" name="last_name" value="{{ old('last_name', $personalInfo->last_name ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                            <input type="text" name="phone" value="{{ old('phone', $personalInfo->phone ?? $user->phone) }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $personalInfo->date_of_birth ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                            <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ old('gender', $personalInfo->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender', $personalInfo->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('gender', $personalInfo->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Address Information -->
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Address Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                            <input type="text" name="address" value="{{ old('address', $personalInfo->address ?? $user->address) }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                            <input type="text" name="city" value="{{ old('city', $personalInfo->city ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">State / Province</label>
                                            <input type="text" name="state" value="{{ old('state', $personalInfo->state ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                            <input type="text" name="country" value="{{ old('country', $personalInfo->country ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">ZIP / Postal Code</label>
                                            <input type="text" name="zip_code" value="{{ old('zip_code', $personalInfo->zip_code ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Professional Information -->
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Professional Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Job Title / Headline</label>
                                            <input type="text" name="title" value="{{ old('title', $jobSeekerProfile->title ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="e.g., Senior Web Developer">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Experience Level</label>
                                            <select name="experience_level" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Level</option>
                                                <option value="entry" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                                <option value="junior" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'junior' ? 'selected' : '' }}>Junior</option>
                                                <option value="mid" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'mid' ? 'selected' : '' }}>Mid Level</option>
                                                <option value="senior" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'senior' ? 'selected' : '' }}>Senior</option>
                                                <option value="lead" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'lead' ? 'selected' : '' }}>Lead</option>
                                                <option value="manager" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'manager' ? 'selected' : '' }}>Manager</option>
                                                <option value="director" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'director' ? 'selected' : '' }}>Director</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Highest Education</label>
                                            <select name="education" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Education</option>
                                                <option value="high_school" {{ old('education', $jobSeekerProfile->education ?? '') == 'high_school' ? 'selected' : '' }}>High School</option>
                                                <option value="diploma" {{ old('education', $jobSeekerProfile->education ?? '') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                                <option value="bachelor" {{ old('education', $jobSeekerProfile->education ?? '') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                                <option value="master" {{ old('education', $jobSeekerProfile->education ?? '') == 'master' ? 'selected' : '' }}>Master's Degree</option>
                                                <option value="phd" {{ old('education', $jobSeekerProfile->education ?? '') == 'phd' ? 'selected' : '' }}>PhD</option>
                                                <option value="other" {{ old('education', $jobSeekerProfile->education ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Bio / About Me</label>
                                        <textarea name="bio" rows="3"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                  placeholder="Tell us about yourself">{{ old('bio', $personalInfo->bio ?? '') }}</textarea>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Professional Summary</label>
                                        <textarea name="summary" rows="4"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                  placeholder="Brief summary of your professional background, skills, and career objectives">{{ old('summary', $jobSeekerProfile->summary ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Save Profile Information
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Education Section -->
            <div id="education" class="section hidden">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Education</h2>
                                <p class="text-sm text-gray-600 mt-1">Add your educational background</p>
                            </div>
                            <button onclick="toggleEducationForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Education
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add Education Form -->
                        <div id="educationForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Add New Education</h3>
                            <form action="{{ route('job-seeker.profile.education.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Institution *</label>
                                        <input type="text" name="institution" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Degree *</label>
                                        <input type="text" name="degree" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                                        <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                        <input type="date" name="end_date" id="education_end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_current" id="education_is_current" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleEducationEndDate()">
                                            <span class="ml-2 text-sm text-gray-700">Currently studying here</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleEducationForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Education
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Education List -->
                        <div class="space-y-4">
                            @forelse($educations as $education)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $education->degree }}</h3>
                                        <p class="text-gray-600 mt-1">{{ $education->institution }}</p>
                                        <div class="flex items-center mt-2 text-sm text-gray-500">
                                            <i class="fas fa-calendar-alt mr-1.5"></i>
                                            <span>{{ $education->start_date->format('M Y') }} - 
                                            {{ $education->is_current ? 'Present' : ($education->end_date ? $education->end_date->format('M Y') : '') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="editEducation({{ $education->id }}, '{{ $education->institution }}', '{{ $education->degree }}', '{{ $education->start_date->format('Y-m-d') }}', '{{ $education->end_date ? $education->end_date->format('Y-m-d') : '' }}', {{ $education->is_current ? 'true' : 'false' }})" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form action="{{ route('job-seeker.profile.education.destroy', $education) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete this education?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-graduation-cap text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No education added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Education" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skills Section -->
            <div id="skills" class="section hidden">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Skills</h2>
                                <p class="text-sm text-gray-600 mt-1">Add your professional skills</p>
                            </div>
                            <button onclick="toggleSkillForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Skill
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add Skill Form -->
                        <div id="skillForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Add New Skill</h3>
                            <form action="{{ route('job-seeker.profile.skill.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Skill Name *</label>
                                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Proficiency Level</label>
                                        <select name="level" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Level</option>
                                            <option value="beginner">Beginner</option>
                                            <option value="intermediate">Intermediate</option>
                                            <option value="advanced">Advanced</option>
                                            <option value="expert">Expert</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleSkillForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Skill
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Skills List -->
                        <div class="flex flex-wrap gap-2">
                            @forelse($skills as $skill)
                            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-3 py-1.5 rounded-full flex items-center">
                                {{ $skill->name }}
                                @if($skill->level)
                                <span class="ml-1.5 text-xs bg-blue-100 px-1.5 py-0.5 rounded">({{ ucfirst($skill->level) }})</span>
                                @endif
                                <form action="{{ route('job-seeker.profile.skill.destroy', $skill) }}" method="POST" class="ml-2">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-blue-500 hover:text-blue-700 text-xs" onclick="return confirm('Remove this skill?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                            @empty
                            <div class="w-full text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-tools text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No skills added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Skill" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Experience Section -->
            <div id="experience" class="section hidden">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Work Experience</h2>
                                <p class="text-sm text-gray-600 mt-1">Add your professional work experience</p>
                            </div>
                            <button onclick="toggleExperienceForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Experience
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add Experience Form -->
                        <div id="experienceForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Add New Experience</h3>
                            <form action="{{ route('job-seeker.profile.experience.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Job Title *</label>
                                        <input type="text" name="job_title" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Company Name *</label>
                                        <input type="text" name="company_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Employment Type</label>
                                        <select name="employment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Type</option>
                                            <option value="full-time">Full-time</option>
                                            <option value="part-time">Part-time</option>
                                            <option value="contract">Contract</option>
                                            <option value="freelance">Freelance</option>
                                            <option value="internship">Internship</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                        <input type="text" name="location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                                        <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                        <input type="date" name="end_date" id="experience_end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_current" id="experience_is_current" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleExperienceEndDate()">
                                            <span class="ml-2 text-sm text-gray-700">I currently work here</span>
                                        </label>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleExperienceForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Experience
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Experience List -->
                        <div class="space-y-4">
                            @forelse($experiences as $experience)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $experience->job_title }}</h3>
                                        <p class="text-gray-600 mt-1">{{ $experience->company_name }}</p>
                                        <div class="flex items-center mt-2 space-x-4 text-sm text-gray-500">
                                            @if($experience->employment_type)
                                            <span class="flex items-center">
                                                <i class="fas fa-briefcase mr-1.5"></i>
                                                {{ ucfirst($experience->employment_type) }}
                                            </span>
                                            @endif
                                            @if($experience->location)
                                            <span class="flex items-center">
                                                <i class="fas fa-map-marker-alt mr-1.5"></i>
                                                {{ $experience->location }}
                                            </span>
                                            @endif
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar-alt mr-1.5"></i>
                                                {{ $experience->start_date->format('M Y') }} - 
                                                {{ $experience->is_current ? 'Present' : ($experience->end_date ? $experience->end_date->format('M Y') : '') }}
                                            </span>
                                        </div>
                                        @if($experience->description)
                                        <p class="mt-3 text-gray-700 text-sm">{{ $experience->description }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="editExperience({{ $experience->id }}, '{{ $experience->job_title }}', '{{ $experience->company_name }}', '{{ $experience->employment_type }}', '{{ $experience->location }}', '{{ $experience->start_date->format('Y-m-d') }}', '{{ $experience->end_date ? $experience->end_date->format('Y-m-d') : '' }}', {{ $experience->is_current ? 'true' : 'false' }}, `{{ $experience->description }}`)" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form action="{{ route('job-seeker.profile.experience.destroy', $experience) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete this experience?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-briefcase text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No work experience added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Experience" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects Section -->
            <div id="projects" class="section hidden">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Projects</h2>
                                <p class="text-sm text-gray-600 mt-1">Showcase your projects and work</p>
                            </div>
                            <button onclick="toggleProjectForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Project
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add Project Form -->
                        <div id="projectForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Add New Project</h3>
                            <form action="{{ route('job-seeker.profile.project.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Project Title *</label>
                                        <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                        <input type="text" name="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                                        <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                        <input type="date" name="end_date" id="project_end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_ongoing" id="project_is_ongoing" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleProjectEndDate()">
                                            <span class="ml-2 text-sm text-gray-700">Currently working on this project</span>
                                        </label>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                                        <textarea name="description" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Project URL (Optional)</label>
                                        <input type="url" name="project_url" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://example.com">
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleProjectForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Project
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Projects List -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($projects as $project)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <h3 class="font-medium text-gray-900">{{ $project->title }}</h3>
                                @if($project->role)
                                <p class="text-sm text-gray-600 mt-1">{{ $project->role }}</p>
                                @endif
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <i class="fas fa-calendar-alt mr-1.5"></i>
                                    <span>{{ $project->start_date->format('M Y') }} - 
                                    {{ $project->is_ongoing ? 'Present' : ($project->end_date ? $project->end_date->format('M Y') : '') }}</span>
                                </div>
                                <p class="mt-3 text-gray-700 text-sm">{{ Str::limit($project->description, 120) }}</p>
                                @if($project->project_url)
                                <a href="{{ $project->project_url }}" target="_blank" class="inline-flex items-center mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-external-link-alt mr-1.5"></i> View Project
                                </a>
                                @endif
                                <div class="mt-4 flex space-x-3">
                                    <button onclick="editProject({{ $project->id }}, '{{ $project->title }}', '{{ $project->role }}', '{{ $project->start_date->format('Y-m-d') }}', '{{ $project->end_date ? $project->end_date->format('Y-m-d') : '' }}', {{ $project->is_ongoing ? 'true' : 'false' }}, `{{ $project->description }}`, '{{ $project->project_url }}')" 
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Edit
                                    </button>
                                    <form action="{{ route('job-seeker.profile.project.destroy', $project) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete this project?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="md:col-span-2 text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-project-diagram text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No projects added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Project" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certifications Section -->
            <div id="certifications" class="section hidden">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Certifications</h2>
                                <p class="text-sm text-gray-600 mt-1">Add your professional certifications</p>
                            </div>
                            <button onclick="toggleCertificationForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Certification
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add Certification Form -->
                        <div id="certificationForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Add New Certification</h3>
                            <form action="{{ route('job-seeker.profile.certification.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Certification Name *</label>
                                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Issuing Organization *</label>
                                        <input type="text" name="issuing_organization" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Issue Date *</label>
                                        <input type="date" name="issue_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Expiration Date</label>
                                        <input type="date" name="expiration_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Credential ID (Optional)</label>
                                        <input type="text" name="credential_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Credential URL (Optional)</label>
                                        <input type="url" name="credential_url" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://example.com/credential">
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleCertificationForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Certification
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Certifications List -->
                        <div class="space-y-4">
                            @forelse($certifications as $certification)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $certification->name }}</h3>
                                        <p class="text-gray-600 mt-1">{{ $certification->issuing_organization }}</p>
                                        <div class="flex items-center mt-2 text-sm text-gray-500">
                                            <i class="fas fa-calendar-alt mr-1.5"></i>
                                            <span>Issued: {{ $certification->issue_date->format('M Y') }}</span>
                                            @if($certification->expiration_date)
                                            <span class="ml-4">
                                                <i class="fas fa-calendar-times mr-1.5"></i>
                                                Expires: {{ $certification->expiration_date->format('M Y') }}
                                            </span>
                                            @endif
                                        </div>
                                        @if($certification->credential_id)
                                        <p class="mt-2 text-sm text-gray-500">Credential ID: {{ $certification->credential_id }}</p>
                                        @endif
                                        @if($certification->credential_url)
                                        <a href="{{ $certification->credential_url }}" target="_blank" class="inline-flex items-center mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <i class="fas fa-external-link-alt mr-1.5"></i> View Credential
                                        </a>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="editCertification({{ $certification->id }}, '{{ $certification->name }}', '{{ $certification->issuing_organization }}', '{{ $certification->issue_date->format('Y-m-d') }}', '{{ $certification->expiration_date ? $certification->expiration_date->format('Y-m-d') : '' }}', '{{ $certification->credential_id }}', '{{ $certification->credential_url }}')" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form action="{{ route('job-seeker.profile.certification.destroy', $certification) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete this certification?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-certificate text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No certifications added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Certification" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Links Section -->
            <div id="social-links" class="section hidden">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Social Links</h2>
                                <p class="text-sm text-gray-600 mt-1">Add your social media profiles</p>
                            </div>
                            <button onclick="toggleSocialLinkForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Social Link
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add Social Link Form -->
                        <div id="socialLinkForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Add New Social Link</h3>
                            <form action="{{ route('job-seeker.profile.social-link.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Platform *</label>
                                        <select name="platform" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Platform</option>
                                            <option value="linkedin">LinkedIn</option>
                                            <option value="github">GitHub</option>
                                            <option value="twitter">Twitter</option>
                                            <option value="facebook">Facebook</option>
                                            <option value="instagram">Instagram</option>
                                            <option value="website">Portfolio Website</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">URL *</label>
                                        <input type="url" name="url" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://example.com/username">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Username (Optional)</label>
                                        <input type="text" name="username" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="username">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_public" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                                            <span class="ml-2 text-sm text-gray-700">Make this link public on your profile</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleSocialLinkForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Social Link
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Social Links List -->
                        <div class="space-y-4">
                            @forelse($socialLinks as $link)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-4">
                                        <!-- Platform Icon -->
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                            @switch($link->platform)
                                                @case('linkedin') <i class="fab fa-linkedin text-blue-600 text-xl"></i> @break
                                                @case('github') <i class="fab fa-github text-gray-800 text-xl"></i> @break
                                                @case('twitter') <i class="fab fa-twitter text-blue-400 text-xl"></i> @break
                                                @case('facebook') <i class="fab fa-facebook text-blue-600 text-xl"></i> @break
                                                @case('instagram') <i class="fab fa-instagram text-pink-600 text-xl"></i> @break
                                                @case('website') <i class="fas fa-globe text-green-600 text-xl"></i> @break
                                                @default <i class="fas fa-link text-gray-600 text-xl"></i>
                                            @endswitch
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ ucfirst($link->platform) }}</h3>
                                            <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm block truncate max-w-xs">
                                                {{ $link->url }}
                                            </a>
                                            @if($link->username)
                                            <p class="text-xs text-gray-500 mt-0.5">Username: {{ $link->username }}</p>
                                            @endif
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $link->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} mt-1">
                                                {{ $link->is_public ? 'Public' : 'Private' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-3">
                                        <button onclick="editSocialLink({{ $link->id }}, '{{ $link->platform }}', '{{ $link->url }}', '{{ $link->username }}', {{ $link->is_public ? 'true' : 'false' }})" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form action="{{ route('job-seeker.profile.social-link.destroy', $link) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete this social link?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-share-alt text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No social links added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Social Link" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visibility Settings Section -->
            <div id="visibility" class="section hidden">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Visibility Settings</h2>
                                <p class="text-sm text-gray-600 mt-1">Control your profile visibility and privacy</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('job-seeker.profile.visibility.update') }}" method="POST">
                            @csrf
                            <div class="space-y-6">
                                <!-- Profile Visibility -->
                                <div class="bg-gray-50 rounded-lg p-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">Profile Visibility</h3>
                                            <p class="text-sm text-gray-600 mt-1">Control who can see your profile</p>
                                        </div>
                                        <select name="profile_visibility" class="w-48 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <option value="public" {{ ($visibilitySettings->profile_visibility ?? '') == 'public' ? 'selected' : '' }}>Public</option>
                                            <option value="private" {{ ($visibilitySettings->profile_visibility ?? '') == 'private' ? 'selected' : '' }}>Private</option>
                                            <option value="recruiters_only" {{ ($visibilitySettings->profile_visibility ?? '') == 'recruiters_only' ? 'selected' : '' }}>Recruiters Only</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Contact Information -->
                                <div class="bg-gray-50 rounded-lg p-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">Contact Information</h3>
                                            <p class="text-sm text-gray-600 mt-1">Show your contact details on profile</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="show_contact_info" value="1" class="sr-only peer" {{ ($visibilitySettings->show_contact_info ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Show Resume -->
                                <div class="bg-gray-50 rounded-lg p-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">Show Resume</h3>
                                            <p class="text-sm text-gray-600 mt-1">Allow recruiters to download your resume</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="show_resume" value="1" class="sr-only peer" {{ ($visibilitySettings->show_resume ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Email Notifications -->
                                <div class="bg-gray-50 rounded-lg p-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">Email Notifications</h3>
                                            <p class="text-sm text-gray-600 mt-1">Receive job alerts and updates</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="email_notifications" value="1" class="sr-only peer" {{ ($visibilitySettings->email_notifications ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Save Visibility Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deletePhotoForm" action="{{ route('job-seeker.profile.photo.delete') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
// Section Management
function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.section').forEach(section => {
        section.classList.add('hidden');
        section.classList.remove('active');
    });
    
    // Show selected section
    const section = document.getElementById(sectionId);
    if (section) {
        section.classList.remove('hidden');
        section.classList.add('active');
    }
    
    // Update sidebar active state
    document.querySelectorAll('nav button').forEach(button => {
        button.classList.remove('bg-blue-50', 'text-blue-700', 'font-medium');
        button.classList.add('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
        button.querySelector('span').classList.remove('bg-blue-600');
        button.querySelector('span').classList.add('bg-transparent');
    });
    
    // Activate current button
    const activeButton = document.querySelector(`button[onclick="showSection('${sectionId}')"]`);
    if (activeButton) {
        activeButton.classList.remove('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
        activeButton.classList.add('bg-blue-50', 'text-blue-700', 'font-medium');
        activeButton.querySelector('span').classList.remove('bg-transparent');
        activeButton.querySelector('span').classList.add('bg-blue-600');
    }
}

// Form Toggle Functions
function toggleEducationForm() {
    const form = document.getElementById('educationForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleSkillForm() {
    const form = document.getElementById('skillForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleExperienceForm() {
    const form = document.getElementById('experienceForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleProjectForm() {
    const form = document.getElementById('projectForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleCertificationForm() {
    const form = document.getElementById('certificationForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleSocialLinkForm() {
    const form = document.getElementById('socialLinkForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

// Date Toggle Functions
function toggleEducationEndDate() {
    const checkbox = document.getElementById('education_is_current');
    const endDate = document.getElementById('education_end_date');
    endDate.disabled = checkbox.checked;
    if (checkbox.checked) {
        endDate.value = '';
    }
}

function toggleExperienceEndDate() {
    const checkbox = document.getElementById('experience_is_current');
    const endDate = document.getElementById('experience_end_date');
    endDate.disabled = checkbox.checked;
    if (checkbox.checked) {
        endDate.value = '';
    }
}

function toggleProjectEndDate() {
    const checkbox = document.getElementById('project_is_ongoing');
    const endDate = document.getElementById('project_end_date');
    endDate.disabled = checkbox.checked;
    if (checkbox.checked) {
        endDate.value = '';
    }
}

// Photo Upload
document.getElementById('profile_photo').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        // Show upload progress
        const progress = document.getElementById('uploadProgress');
        progress.classList.remove('hidden');
        
        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profilePhotoPreview');
            if (preview) {
                preview.src = e.target.result;
            } else {
                // Create preview if it doesn't exist (for default avatar)
                const profileSection = document.querySelector('.text-center .relative');
                if (profileSection) {
                    const img = document.createElement('img');
                    img.id = 'profilePhotoPreview';
                    img.src = e.target.result;
                    img.alt = 'Profile Photo';
                    img.className = 'w-32 h-32 rounded-full object-cover border-4 border-white shadow-md mx-auto';
                    profileSection.querySelector('div, img').replaceWith(img);
                }
            }
        }
        reader.readAsDataURL(this.files[0]);
        
        // Submit form
        document.getElementById('photoUploadForm').submit();
    }
});

function confirmDeletePhoto() {
    if (confirm('Are you sure you want to delete your profile photo?')) {
        document.getElementById('deletePhotoForm').submit();
    }
}

function toggleEducationForm() {
    document.getElementById('educationForm').classList.toggle('hidden');
}

function toggleEditEducationForm() {
    document.getElementById('editEducationForm').classList.toggle('hidden');
}

function toggleSkillForm() {
    document.getElementById('skillForm').classList.toggle('hidden');
}

function toggleExperienceForm() {
    document.getElementById('experienceForm').classList.toggle('hidden');
}

function toggleEditExperienceForm() {
    document.getElementById('editExperienceForm').classList.toggle('hidden');
}

function toggleProjectForm() {
    document.getElementById('projectForm').classList.toggle('hidden');
}

function toggleEditProjectForm() {
    document.getElementById('editProjectForm').classList.toggle('hidden');
}

function toggleCertificationForm() {
    document.getElementById('certificationForm').classList.toggle('hidden');
}

function toggleEditCertificationForm() {
    document.getElementById('editCertificationForm').classList.toggle('hidden');
}

// Edit functions
function editEducation(id, institution, degree, startDate, endDate, isCurrent) {
    document.getElementById('editEducationForm').classList.remove('hidden');
    document.getElementById('edit_institution').value = institution;
    document.getElementById('edit_degree').value = degree;
    document.getElementById('edit_start_date').value = startDate;
    document.getElementById('edit_end_date').value = endDate;
    document.getElementById('edit_is_current').checked = isCurrent;
    
    // Set form action
    const form = document.getElementById('editEducationFormElement');
    form.action = `/job-seeker/profile/education/${id}`;
    
    // Scroll to form
    document.getElementById('editEducationForm').scrollIntoView({ behavior: 'smooth' });
}

function editExperience(id, jobTitle, companyName, employmentType, location, startDate, endDate, isCurrent, description) {
    document.getElementById('editExperienceForm').classList.remove('hidden');
    document.getElementById('edit_job_title').value = jobTitle;
    document.getElementById('edit_company_name').value = companyName;
    document.getElementById('edit_employment_type').value = employmentType;
    document.getElementById('edit_location').value = location;
    document.getElementById('edit_experience_start_date').value = startDate;
    document.getElementById('edit_experience_end_date').value = endDate;
    document.getElementById('edit_experience_is_current').checked = isCurrent === 'true';
    document.getElementById('edit_experience_description').value = description;
    
    // Set form action
    const form = document.getElementById('editExperienceFormElement');
    form.action = `/job-seeker/profile/experience/${id}`;
    
    // Scroll to form
    document.getElementById('editExperienceForm').scrollIntoView({ behavior: 'smooth' });
}

function editProject(id, title, role, startDate, endDate, isOngoing, description, projectUrl) {
    document.getElementById('editProjectForm').classList.remove('hidden');
    document.getElementById('edit_project_title').value = title;
    document.getElementById('edit_project_role').value = role;
    document.getElementById('edit_project_start_date').value = startDate;
    document.getElementById('edit_project_end_date').value = endDate;
    document.getElementById('edit_project_is_ongoing').checked = isOngoing === 'true';
    document.getElementById('edit_project_description').value = description;
    document.getElementById('edit_project_url').value = projectUrl;
    
    // Set form action
    const form = document.getElementById('editProjectFormElement');
    form.action = `/job-seeker/profile/project/${id}`;
    
    // Scroll to form
    document.getElementById('editProjectForm').scrollIntoView({ behavior: 'smooth' });
}

function editCertification(id, name, issuingOrganization, issueDate, expirationDate, credentialId, credentialUrl) {
    document.getElementById('editCertificationForm').classList.remove('hidden');
    document.getElementById('edit_certification_name').value = name;
    document.getElementById('edit_issuing_organization').value = issuingOrganization;
    document.getElementById('edit_issue_date').value = issueDate;
    document.getElementById('edit_expiration_date').value = expirationDate;
    document.getElementById('edit_credential_id').value = credentialId;
    document.getElementById('edit_credential_url').value = credentialUrl;
    
    // Set form action
    const form = document.getElementById('editCertificationFormElement');
    form.action = `/job-seeker/profile/certification/${id}`;
    
    // Scroll to form
    document.getElementById('editCertificationForm').scrollIntoView({ behavior: 'smooth' });
}

// Social Link Functions
function toggleSocialLinkForm() {
    document.getElementById('socialLinkForm').classList.toggle('hidden');
}

function toggleEditSocialLinkForm() {
    document.getElementById('editSocialLinkForm').classList.toggle('hidden');
}

function editSocialLink(id, platform, url, username, isPublic) {
    document.getElementById('editSocialLinkForm').classList.remove('hidden');
    document.getElementById('edit_social_platform').value = platform;
    document.getElementById('edit_social_url').value = url;
    document.getElementById('edit_social_username').value = username || '';
    document.getElementById('edit_social_is_public').checked = isPublic === 'true';
    
    // Set form action
    const form = document.getElementById('editSocialLinkFormElement');
    form.action = `/job-seeker/profile/social-link/${id}`;
    
    // Scroll to form
    document.getElementById('editSocialLinkForm').scrollIntoView({ behavior: 'smooth' });
}

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            // Update active state in sidebar
            document.querySelectorAll('#sidebar a').forEach(link => {
                link.classList.remove('text-blue-600');
                link.classList.add('text-gray-600');
            });
            this.classList.remove('text-gray-600');
            this.classList.add('text-blue-600');
            
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Handle is_current checkbox for education
document.querySelectorAll('input[name="is_current"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const endDateInput = this.closest('form').querySelector('input[name="end_date"]');
        if (this.checked) {
            endDateInput.disabled = true;
            endDateInput.value = '';
        } else {
            endDateInput.disabled = false;
        }
    });
});

// Handle is_ongoing checkbox for projects
document.querySelectorAll('input[name="is_ongoing"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const endDateInput = this.closest('form').querySelector('input[name="end_date"]');
        if (this.checked) {
            endDateInput.disabled = true;
            endDateInput.value = '';
        } else {
            endDateInput.disabled = false;
        }
    });
});

// Initialize date inputs
document.addEventListener('DOMContentLoaded', function() {
    // Disable end dates if is_current/is_ongoing is checked
    document.querySelectorAll('input[name="is_current"]:checked').forEach(checkbox => {
        const endDateInput = checkbox.closest('form').querySelector('input[name="end_date"]');
        if (endDateInput) endDateInput.disabled = true;
    });
    
    document.querySelectorAll('input[name="is_ongoing"]:checked').forEach(checkbox => {
        const endDateInput = checkbox.closest('form').querySelector('input[name="end_date"]');
        if (endDateInput) endDateInput.disabled = true;
    });
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Show first section by default
    showSection('basic-profile');
    
    // Initialize date toggles
    toggleEducationEndDate();
    toggleExperienceEndDate();
    toggleProjectEndDate();
});
</script>

<style>
.section {
    display: block;
}

.section.hidden {
    display: none;
}

.section.active {
    display: block;
}

/* Smooth transitions */
.section, button, input, select, textarea {
    transition: all 0.2s ease-in-out;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}
</style>
@endsection