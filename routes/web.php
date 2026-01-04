<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\JobSeeker\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

// Public routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Job Seeker routes
    Route::middleware(['role:job_seeker'])->prefix('job-seeker')->name('job-seeker.')->group(function () {
        Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/applications', [ApplicationController::class, 'myApplications'])->name('applications');
    });
    
    // Application routes
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'apply'])->name('jobs.apply');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('/jobs', AdminJobController::class)->except(['create', 'store', 'edit']);
        Route::post('/jobs/{job}/status', [AdminJobController::class, 'updateStatus'])->name('jobs.update-status');
        
        Route::resource('/applications', AdminApplicationController::class)->except(['create', 'store', 'edit']);
        Route::post('/applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.update-status');
        
        Route::resource('/users', AdminUserController::class)->except(['create', 'store']);
        
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});