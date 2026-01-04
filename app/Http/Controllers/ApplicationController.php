<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function apply(Request $request, Job $job)
    {
        $request->validate([
            'cover_letter' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = [
            'job_id' => $job->id,
            'user_id' => auth()->id(),
            'cover_letter' => $request->cover_letter,
        ];

        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('applications', 'public');
            $data['resume'] = $path;
        } elseif (auth()->user()->jobSeekerProfile?->resume_file) {
            $data['resume'] = auth()->user()->jobSeekerProfile->resume_file;
        }

        JobApplication::create($data);

        return redirect()->back()->with('success', 'Application submitted successfully.');
    }

    public function myApplications()
    {
        $applications = JobApplication::with('job')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('applications.index', compact('applications'));
    }
}