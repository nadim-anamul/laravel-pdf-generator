<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordManagementController extends Controller
{
    /**
     * Show password change form for current user
     */
    public function showChangeForm()
    {
        return view('auth.change-password');
    }

    /**
     * Handle user password change
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'বর্তমান পাসওয়ার্ড প্রয়োজন',
            'password.required' => 'নতুন পাসওয়ার্ড প্রয়োজন',
            'password.min' => 'নতুন পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলেনি',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'বর্তমান পাসওয়ার্ড ভুল।',
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Mark password as changed (clears must_change_password flag)
        $user->update([
            'must_change_password' => false,
            'password_changed_at' => now(),
            'password_reset_by' => null,
            'password_reset_reason' => null,
        ]);

        return redirect()->route('home')->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!');
    }

    /**
     * Show forced password change form (when admin resets password)
     */
    public function showForcedChangeForm()
    {
        $user = Auth::user();
        
        if (!$user->must_change_password) {
            return redirect()->route('home');
        }

        return view('auth.forced-password-change');
    }

    /**
     * Handle forced password change
     */
    public function forcedPasswordChange(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->must_change_password) {
            return redirect()->route('home');
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'নতুন পাসওয়ার্ড প্রয়োজন',
            'password.min' => 'নতুন পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলেনি',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Mark password as changed
        $user->update([
            'must_change_password' => false,
            'password_changed_at' => now(),
            'password_reset_by' => null,
            'password_reset_reason' => null,
        ]);

        return redirect()->route('home')->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!');
    }

    /**
     * Admin reset user password (Super User only)
     */
    public function adminResetPassword(Request $request, User $user)
    {
        // Check if current user is super user
        if (!Auth::user()->is_super_user) {
            abort(403, 'অনুমতি নেই।');
        }

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string|min:6',
            'reset_reason' => 'nullable|string|max:500',
        ], [
            'new_password.required' => 'নতুন পাসওয়ার্ড প্রয়োজন',
            'new_password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে',
            'reset_reason.max' => 'কারণ ৫০০ অক্ষরের বেশি হতে পারে না',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Prevent resetting super user password by another super user
        if ($user->is_super_user && $user->id !== Auth::id()) {
            return back()->with('error', 'অন্য সুপার ইউজারের পাসওয়ার্ড রিসেট করা যাবে না।');
        }

        // Update user password and mark for forced change
        $user->update([
            'password' => Hash::make($request->new_password),
            'must_change_password' => true,
            'password_reset_by' => Auth::id(),
            'password_reset_reason' => $request->reset_reason,
            'password_changed_at' => now(),
        ]);

        return back()->with('success', "ইউজার '{$user->name}' এর পাসওয়ার্ড রিসেট করা হয়েছে। পরবর্তী লগইনে তাকে পাসওয়ার্ড পরিবর্তন করতে হবে।");
    }
}