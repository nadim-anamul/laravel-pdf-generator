<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    /**
     * Show pending user registrations (Super User only)
     */
    public function index()
    {
        // Check if current user is super user
        if (!Auth::user()->is_super_user) {
            abort(403, 'অনুমতি নেই। শুধুমাত্র সুপার ইউজার এই পেজ দেখতে পারেন।');
        }

        $pendingUsers = User::pendingApproval()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $approvedUsers = User::approved()
            ->with('approvedBy')
            ->orderBy('approved_at', 'desc')
            ->paginate(10);

        return view('admin.user-management', compact('pendingUsers', 'approvedUsers'));
    }

    /**
     * Approve a user registration
     */
    public function approve(Request $request, User $user)
    {
        // Check if current user is super user
        if (!Auth::user()->is_super_user) {
            abort(403, 'অনুমতি নেই।');
        }

        if ($user->is_approved) {
            return back()->with('error', 'এই ইউজার ইতিমধ্যে অনুমোদিত।');
        }

        $user->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', "ইউজার '{$user->name}' সফলভাবে অনুমোদিত হয়েছে।");
    }

    /**
     * Reject a user registration
     */
    public function reject(Request $request, User $user)
    {
        // Check if current user is super user
        if (!Auth::user()->is_super_user) {
            abort(403, 'অনুমতি নেই।');
        }

        if ($user->is_approved) {
            return back()->with('error', 'অনুমোদিত ইউজারকে প্রত্যাখ্যান করা যাবে না।');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', "ইউজার '{$userName}' প্রত্যাখ্যান করা হয়েছে এবং ডিলিট করা হয়েছে।");
    }

    /**
     * Revoke user approval (suspend user)
     */
    public function revoke(Request $request, User $user)
    {
        // Check if current user is super user
        if (!Auth::user()->is_super_user) {
            abort(403, 'অনুমতি নেই।');
        }

        if (!$user->is_approved) {
            return back()->with('error', 'এই ইউজার এখনো অনুমোদিত নয়।');
        }

        if ($user->is_super_user) {
            return back()->with('error', 'সুপার ইউজারের অনুমোদন বাতিল করা যাবে না।');
        }

        $user->update([
            'is_approved' => false,
            'approved_at' => null,
            'approved_by' => null,
        ]);

        return back()->with('success', "ইউজার '{$user->name}' এর অনুমোদন বাতিল করা হয়েছে।");
    }

    /**
     * Make user super user
     */
    public function makeSuperUser(Request $request, User $user)
    {
        // Check if current user is super user
        if (!Auth::user()->is_super_user) {
            abort(403, 'অনুমতি নেই।');
        }

        if ($user->is_super_user) {
            return back()->with('error', 'এই ইউজার ইতিমধ্যে সুপার ইউজার।');
        }

        if (!$user->is_approved) {
            return back()->with('error', 'প্রথমে ইউজারকে অনুমোদন করুন।');
        }

        $user->update([
            'is_super_user' => true,
        ]);

        return back()->with('success', "ইউজার '{$user->name}' কে সুপার ইউজার বানানো হয়েছে।");
    }

    /**
     * Remove super user status
     */
    public function removeSuperUser(Request $request, User $user)
    {
        // Check if current user is super user
        if (!Auth::user()->is_super_user) {
            abort(403, 'অনুমতি নেই।');
        }

        if (!$user->is_super_user) {
            return back()->with('error', 'এই ইউজার সুপার ইউজার নয়।');
        }

        // Prevent removing super user status from self
        if ($user->id === Auth::id()) {
            return back()->with('error', 'আপনি নিজের সুপার ইউজার স্ট্যাটাস সরাতে পারবেন না।');
        }

        $user->update([
            'is_super_user' => false,
        ]);

        return back()->with('success', "ইউজার '{$user->name}' এর সুপার ইউজার স্ট্যাটাস সরানো হয়েছে।");
    }
}