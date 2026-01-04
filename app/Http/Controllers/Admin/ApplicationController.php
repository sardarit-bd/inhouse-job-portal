<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::with(['job', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.applications.index', compact('applications'));
    }

    public function show(JobApplication $application)
    {
        $application->load(['job', 'user.jobSeekerProfile']);
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,rejected,hired',
            'interview_notes' => 'nullable|string',
        ]);

        $data = ['status' => $request->status];
        
        if ($request->filled('interview_notes')) {
            $notes = $application->interview_notes ?? [];
            $notes[] = [
                'note' => $request->interview_notes,
                'date' => now()->toDateTimeString(),
                'admin' => auth()->user()->name,
            ];
            $data['interview_notes'] = $notes;
        }

        $application->update($data);

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }
}