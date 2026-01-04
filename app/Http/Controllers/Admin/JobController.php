<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        $job->load(['user', 'applications.user']);
        return view('admin.jobs.show', compact('job'));
    }

    public function updateStatus(Request $request, Job $job)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $job->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Job status updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job deleted successfully.');
    }
}