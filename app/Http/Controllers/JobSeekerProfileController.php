<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Certification;
use App\Models\SocialLink;
use App\Models\ProfileVisibilitySetting;
use App\Models\User;
use App\Models\JobSeekerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // ✅ ADD THIS LINE

class JobSeekerProfileController extends Controller
{
    
    public function edit()
    {
        $user = Auth::user();
        
        // Get or create job seeker profile
        $jobSeekerProfile = JobSeekerProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'title' => '',
                'summary' => '',
                'skills' => json_encode([]),
                'experience_level' => '',
                'education' => '',
                'resume_file' => null,
                'work_experience' => json_encode([]),
                'education_history' => json_encode([]),
                'personal_info_id' => $user->personalInformation->id ?? null
            ]
        );
        
        // Get personal information
        $personalInfo = $user->personalInformation ?? new PersonalInformation();
        
        return view('jobseeker.profile.edit', [
            'user' => $user,
            'jobSeekerProfile' => $jobSeekerProfile,
            'personalInfo' => $personalInfo,
            'educations' => $user->educations,
            'skills' => $user->skills,
            'experiences' => $user->experiences,
            'projects' => $user->projects,
            'certifications' => $user->certifications,
            'socialLinks' => $user->socialLinks,
            'visibilitySettings' => $user->profileVisibilitySetting ?? new ProfileVisibilitySetting(),
        ]);
    }

    public function completeUpdate(Request $request)
    {
        $user = Auth::user();
        
        // Validate all fields
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today', 
            'gender' => 'nullable|in:male,female,other',     
            'bio' => 'nullable|string|max:1000', 
            'title' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'experience_level' => 'nullable|in:entry,junior,mid,senior,lead,manager,director',
            'education' => 'nullable|in:high_school,diploma,bachelor,master,phd,other',
        ], [
            'email.unique' => 'This email is already taken by another user.',
            'name.required' => 'User name is required.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Update users table
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            
            // Only update phone and address if they exist in users table
            if (in_array('phone', $user->getFillable())) {
                $userData['phone'] = $request->phone;
            }
            
            if (in_array('address', $user->getFillable())) {
                $userData['address'] = $request->address;
            }
            
            $user->update($userData);
            
            // Update or create personal_information
            $personalInfoData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zip_code' => $request->zip_code,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,               
                'bio' => $request->bio, 
            ];
            
            PersonalInformation::updateOrCreate(
                ['user_id' => $user->id],
                $personalInfoData
            );
            
            // Update or create job_seeker_profiles
            $jobSeekerData = [
                'title' => $request->title,
                'summary' => $request->summary,
                'experience_level' => $request->experience_level,
                'education' => $request->education,
            ];
            
            // Remove null values
            $jobSeekerData = array_filter($jobSeekerData, function($value) {
                return !is_null($value);
            });
            
            if (!empty($jobSeekerData)) {
                JobSeekerProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    $jobSeekerData
                );
            }
            
            DB::commit();
            
            return redirect()->back()
                ->with('profile_update', 'Profile updated successfully!')
                ->with('success', 'All profile information has been updated.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Failed to update profile: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateBasicProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validate request using validate() method directly on request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'title' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'experience_level' => 'nullable|string|max:100',
            'education' => 'nullable|string|max:255',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Update users table
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? $user->phone,
                'address' => $validated['address'] ?? $user->address,
            ]);
            
            // Update or create job_seeker_profiles table
            JobSeekerProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'title' => $validated['title'] ?? '',
                    'summary' => $validated['summary'] ?? '',
                    'experience_level' => $validated['experience_level'] ?? '',
                    'education' => $validated['education'] ?? '',
                ]
            );
            
            DB::commit();
            
            return redirect()->route('job-seeker.profile.edit')
                ->with('success', 'Basic profile information updated successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('job-seeker.profile.edit')
                ->with('error', 'Failed to update profile: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updatePersonalInfo(Request $request)
    {
        $user = Auth::user();
        
        // Split full name into first and last name
        $fullName = $request->input('full_name', '');
        $nameParts = explode(' ', $fullName, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';
        
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Add first_name and last_name to validated data
            $personalInfoData = array_merge($validated, [
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
            
            // Remove full_name from array since it doesn't exist in personal_information table
            unset($personalInfoData['full_name']);
            
            // Update personal information
            $personalInfo = $user->personalInformation()->updateOrCreate(
                ['user_id' => $user->id],
                $personalInfoData
            );
            
            // Also update user's phone and address if they are empty in users table
            if (empty($user->phone) && !empty($validated['phone'])) {
                $user->update(['phone' => $validated['phone']]);
            }
            
            if (empty($user->address) && !empty($validated['address'])) {
                $user->update(['address' => $validated['address']]);
            }
            
            // Update job_seeker_profiles personal_info_id
            $jobSeekerProfile = JobSeekerProfile::where('user_id', $user->id)->first();
            if ($jobSeekerProfile) {
                $jobSeekerProfile->update([
                    'personal_info_id' => $personalInfo->id
                ]);
            }
            
            DB::commit();

            return redirect()->route('job-seeker.profile.edit')
                ->with('success', 'Personal information updated successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('job-seeker.profile.edit')
                ->with('error', 'Failed to update personal information: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Education methods
    public function storeEducation(Request $request)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'grade' => 'nullable|string|max:50',
            'activities' => 'nullable|array',
        ]);

        $user = Auth::user();
        $user->educations()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Education added successfully.');
    }

    public function updateEducation(Request $request, Education $education)
    {
        if (Auth::id() !== $education->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'grade' => 'nullable|string|max:50',
            'activities' => 'nullable|array',
        ]);

        $education->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Education updated successfully.');
    }

    public function destroyEducation(Education $education)
    {
        if (Auth::id() !== $education->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $education->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Education deleted successfully.');
    }

    // Skill methods
    public function storeSkill(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|in:beginner,intermediate,advanced,expert',
            'years_of_experience' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $user->skills()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Skill added successfully.');
    }

    public function updateSkill(Request $request, Skill $skill)
    {
        if (Auth::id() !== $skill->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|in:beginner,intermediate,advanced,expert',
            'years_of_experience' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:100',
        ]);

        $skill->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Skill updated successfully.');
    }

    public function destroySkill(Skill $skill)
    {
        if (Auth::id() !== $skill->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $skill->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Skill deleted successfully.');
    }

    // Experience methods
    public function storeExperience(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'employment_type' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_current' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|array',
            'industry' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->experiences()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Experience added successfully.');
    }

    public function updateExperience(Request $request, Experience $experience)
    {
        if (Auth::id() !== $experience->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'employment_type' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_current' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|array',
            'industry' => 'nullable|string|max:255',
        ]);

        $experience->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Experience updated successfully.');
    }

    public function destroyExperience(Experience $experience)
    {
        if (Auth::id() !== $experience->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $experience->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Experience deleted successfully.');
    }

    // Project methods
    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'role' => 'nullable|string|max:255',
            'technologies_used' => 'nullable|array',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_ongoing' => 'boolean',
            'project_url' => 'nullable|url|max:255',
            'images' => 'nullable|array',
        ]);

        $user = Auth::user();
        $user->projects()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Project added successfully.');
    }

    public function updateProject(Request $request, Project $project)
    {
        if (Auth::id() !== $project->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'role' => 'nullable|string|max:255',
            'technologies_used' => 'nullable|array',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_ongoing' => 'boolean',
            'project_url' => 'nullable|url|max:255',
            'images' => 'nullable|array',
        ]);

        $project->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Project updated successfully.');
    }

    public function destroyProject(Project $project)
    {
        if (Auth::id() !== $project->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $project->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Project deleted successfully.');
    }

    // Certification methods
    public function storeCertification(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'skills' => 'nullable|array',
        ]);

        $user = Auth::user();
        $user->certifications()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Certification added successfully.');
    }

    public function updateCertification(Request $request, Certification $certification)
    {
        if (Auth::id() !== $certification->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'skills' => 'nullable|array',
        ]);

        $certification->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Certification updated successfully.');
    }

    public function destroyCertification(Certification $certification)
    {
        if (Auth::id() !== $certification->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $certification->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Certification deleted successfully.');
    }

    // Social Link methods
    public function storeSocialLink(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'username' => 'nullable|string|max:255',
            'is_public' => 'boolean',
        ]);

        $user = Auth::user();
        $user->socialLinks()->create($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Social link added successfully.');
    }

    public function updateSocialLink(Request $request, SocialLink $socialLink)
    {
        if (Auth::id() !== $socialLink->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'username' => 'nullable|string|max:255',
            'is_public' => 'boolean',
        ]);

        $socialLink->update($validated);

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Social link updated successfully.');
    }

    public function destroySocialLink(SocialLink $socialLink)
    {
        if (Auth::id() !== $socialLink->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $socialLink->delete();

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Social link deleted successfully.');
    }

    // Visibility Settings method
    public function updateVisibilitySettings(Request $request)
    {
        $validated = $request->validate([
            'make_profile_public' => 'boolean',
            'show_education' => 'boolean',
            'show_experience' => 'boolean',
            'show_projects' => 'boolean',
            'show_certifications' => 'boolean',
            'show_skills' => 'boolean',
            'show_social_links' => 'boolean',
            'show_contact_info' => 'boolean',
        ]);

        $user = Auth::user();
        $user->profileVisibilitySetting()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('job-seeker.profile.edit')->with('success', 'Visibility settings updated successfully.');
    }

    // Profile Stats method
    public function getProfileStats()
    {
        $user = Auth::user();
        
        $profileViews = $user->profileViews()->count();
        $jobViews = $user->jobApplications()->count();

        return response()->json([
            'profile_views' => $profileViews,
            'job_views' => $jobViews,
        ]);
    }
    
    // Profile Photo methods
    public function updateProfilePhoto(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Delete old profile photo if exists
            if ($user->profile_photo) {
                $oldPhotoPath = public_path('storage/' . $user->profile_photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
            
            // Store new profile photo
            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                $user->update([
                    'profile_photo' => $path
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('job-seeker.profile.edit')
                ->with('success', 'Profile photo updated successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('job-seeker.profile.edit')
                ->with('error', 'Failed to update profile photo: ' . $e->getMessage());
        }
    }

    public function deleteProfilePhoto()
    {
        $user = Auth::user();
        
        if (!$user->profile_photo) {
            return redirect()->route('job-seeker.profile.edit')
                ->with('error', 'No profile photo to delete.');
        }
        
        DB::beginTransaction();
        
        try {
            // Delete file from storage
            $oldPhotoPath = public_path('storage/' . $user->profile_photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
            
            // Update database
            $user->update([
                'profile_photo' => null
            ]);
            
            DB::commit();
            
            return redirect()->route('job-seeker.profile.edit')
                ->with('success', 'Profile photo deleted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('job-seeker.profile.edit')
                ->with('error', 'Failed to delete profile photo: ' . $e->getMessage());
        }
    }
    
    
}