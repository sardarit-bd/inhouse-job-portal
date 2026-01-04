<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_jobs' => Job::count(),
            'pending_jobs' => Job::where('status', 'pending')->count(),
            'total_applications' => JobApplication::count(),
            'total_hires' => JobApplication::where('status', 'hired')->count(),
            'total_job_seekers' => User::where('role', 'job_seeker')->count(),
            'total_companies' => User::where('role', 'admin')->count(),
        ];

        $recentJobs = Job::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $recentApplications = JobApplication::with(['job', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentJobs', 'recentApplications'));
    }
}