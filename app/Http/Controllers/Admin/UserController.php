<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Start query
        $query = User::withCount(['jobApplications', 'postedJobs']);
        
        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Role filter
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }
        
        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('is_active', $request->status === 'active');
        }
        
        // Sort by latest
        $query->orderBy('created_at', 'desc');
        
        $users = $query->paginate(10);
        
        // Get statistics
        $totalUsers = User::count();
        $adminsCount = User::where('role', 'admin')->count();
        $jobSeekersCount = User::where('role', 'job_seeker')->count();
        $activeTodayCount = User::whereDate('created_at', today())->count();
        
        // AJAX response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'users' => $users,
                'stats' => [
                    'total' => $totalUsers,
                    'admins' => $adminsCount,
                    'job_seekers' => $jobSeekersCount,
                    'active_today' => $activeTodayCount
                ]
            ]);
        }
        
        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'adminsCount',
            'jobSeekersCount',
            'activeTodayCount'
        ));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin,job_seeker',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,job_seeker',
            'is_active' => 'boolean',
        ]);

        if ($request->has('password') && $request->password) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->is_active = $request->boolean('is_active');
        $user->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting admin users
        if ($user->role === 'admin') {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete admin users.'
                ], 403);
            }
            return redirect()->back()
                ->with('error', 'Cannot delete admin users.');
        }

        $user->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully',
                'is_active' => $user->is_active
            ]);
        }

        return redirect()->back()
            ->with('success', 'User status updated successfully.');
    }
    
    public function verifyEmail(User $user)
    {
        if ($user->email_verified_at) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User email is already verified.'
                ], 400);
            }
            return redirect()->back()
                ->with('error', 'User email is already verified.');
        }

        $user->email_verified_at = now();
        $user->save();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully',
                'email_verified_at' => $user->email_verified_at
            ]);
        }

        return redirect()->back()
            ->with('success', 'Email verified successfully.');
    }

    public function unverifyEmail(User $user)
    {
        if (!$user->email_verified_at) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User email is already unverified.'
                ], 400);
            }
            return redirect()->back()
                ->with('error', 'User email is already unverified.');
        }

        $user->email_verified_at = null;
        $user->save();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Email unverified successfully',
                'email_verified_at' => $user->email_verified_at
            ]);
        }

        return redirect()->back()
            ->with('success', 'Email unverified successfully.');
    }

    public function resendVerification(User $user)
    {
        // Implement email verification resend logic here
        // You can use Laravel's built-in verification notification
        
        if ($user->email_verified_at) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User email is already verified.'
                ], 400);
            }
            return redirect()->back()
                ->with('error', 'User email is already verified.');
        }

        // Send verification email
        // $user->sendEmailVerificationNotification();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Verification email sent successfully'
            ]);
        }

        return redirect()->back()
            ->with('success', 'Verification email sent successfully.');
    }
}