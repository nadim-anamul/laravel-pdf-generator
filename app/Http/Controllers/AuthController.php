<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // Redirect to home if already logged in
        if (Auth::check()) {
            return redirect()->route('home');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'ইমেইল ঠিকানা প্রয়োজন',
            'email.email' => 'সঠিক ইমেইল ঠিকানা দিন',
            'password.required' => 'পাসওয়ার্ড প্রয়োজন',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check if user is approved
            if (!$user->is_approved) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'আপনার অ্যাকাউন্ট এখনো অনুমোদিত হয়নি। অনুমোদনের জন্য অপেক্ষা করুন।',
                ])->withInput();
            }
            
            $request->session()->regenerate();
            
            // Check if user must change password
            if ($user->must_change_password) {
                return redirect()->route('password.forced-change')->with('info', 'আপনার পাসওয়ার্ড রিসেট করা হয়েছে। নিরাপত্তার জন্য নতুন পাসওয়ার্ড সেট করুন।');
            }
            
            return redirect()->intended(route('home'))->with('success', 'সফলভাবে লগইন হয়েছে!');
        }

        return back()->withErrors([
            'email' => 'ইমেইল বা পাসওয়ার্ড ভুল।',
        ])->withInput();
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        // Redirect to home if already logged in
        if (Auth::check()) {
            return redirect()->route('home');
        }
        
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'নাম প্রয়োজন',
            'name.max' => 'নাম ২৫৫ অক্ষরের বেশি হতে পারে না',
            'email.required' => 'ইমেইল ঠিকানা প্রয়োজন',
            'email.email' => 'সঠিক ইমেইল ঠিকানা দিন',
            'email.unique' => 'এই ইমেইল ঠিকানা ইতিমধ্যে ব্যবহৃত হয়েছে',
            'password.required' => 'পাসওয়ার্ড প্রয়োজন',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলেনি',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'registration_note' => $request->registration_note,
            'is_approved' => false,
        ]);

        // Don't auto-login, user needs approval first
        return redirect()->route('login')->with('success', 'রেজিস্ট্রেশন সম্পন্ন হয়েছে! আপনার অ্যাকাউন্ট অনুমোদনের জন্য অপেক্ষা করুন। অনুমোদনের পর আপনি লগইন করতে পারবেন।');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'সফলভাবে লগআউট হয়েছে!');
    }
}
