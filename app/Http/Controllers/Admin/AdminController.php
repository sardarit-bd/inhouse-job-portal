<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $query = User::where('role', 'admin')
                    ->orderBy('is_super_admin', 'desc')
                    ->orderBy('created_at', 'desc');
        
        // Apply filters if any
        if (request()->has('search') && request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if (request()->has('type')) {
            if (request('type') === 'super') {
                $query->where('is_super_admin', true);
            } elseif (request('type') === 'normal') {
                $query->where('is_super_admin', false);
            }
        }
        
        if (request()->has('status')) {
            if (request('status') === 'active') {
                $query->where('is_active', true);
            } elseif (request('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        $admins = $query->paginate(10);
        
        // Statistics
        $superAdminsCount = User::where('role', 'admin')->where('is_super_admin', true)->count();
        $activeAdminsCount = User::where('role', 'admin')->where('is_active', true)->count();
        $recentAdminsCount = User::where('role', 'admin')
                                ->where('created_at', '>=', now()->subDays(7))
                                ->count();
        
        // AJAX request হলে JSON response দিবে
        if (request()->ajax()) {
            return response()->json([
                'admins' => $admins,
                'stats' => [
                    'superAdmins' => $superAdminsCount,
                    'activeAdmins' => $activeAdminsCount,
                    'recentAdmins' => $recentAdminsCount,
                ]
            ]);
        }
        
        return view('admin.admins.index', compact('admins', 'superAdminsCount', 'activeAdminsCount', 'recentAdminsCount'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_super_admin' => 'nullable|boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'is_super_admin' => $request->has('is_super_admin') ? 1 : 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete yourself.'
                ], 403);
            }
            return redirect()->route('admin.admins.index')
                ->with('error', 'You cannot delete yourself.');
        }

        if ($admin->role !== 'admin') {
            abort(403, 'Only admin users can be deleted.');
        }

        $admin->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Admin deleted successfully.'
            ]);
        }

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully.');
    }

    public function toggleStatus(User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(403, 'Only admin users can be toggled.');
        }
        
        if ($admin->id === auth()->id()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot change your own status.'
                ], 403);
            }
            
            return redirect()->back()
                ->with('error', 'You cannot change your own status.');
        }
        
        $admin->update([
            'is_active' => !$admin->is_active
        ]);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Admin status updated successfully.',
                'is_active' => $admin->is_active
            ]);
        }
        
        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin status updated successfully.');
    }

    public function toggleEmailVerification(User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(403, 'Only admin users can be managed.');
        }
        
        if ($admin->id === auth()->id()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot change your own verification status.'
                ], 403);
            }
            return redirect()->back()
                ->with('error', 'You cannot change your own verification status.');
        }
        
        // Toggle verification status
        if ($admin->email_verified_at) {
            $admin->email_verified_at = null;
        } else {
            $admin->email_verified_at = now();
        }
        
        $admin->save();
        
        $action = $admin->email_verified_at ? 'verified' : 'unverified';
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Email {$action} successfully.",
                'is_verified' => (bool) $admin->email_verified_at,
                'verified_at' => $admin->email_verified_at ? $admin->email_verified_at->format('M d, Y') : null
            ]);
        }
        
        return redirect()->route('admin.admins.index')
            ->with('success', "Email {$action} successfully.");
    }
}