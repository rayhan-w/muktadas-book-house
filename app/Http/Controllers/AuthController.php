<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            if (Auth::user()->isPublisher()) {
                return redirect()->route('publisher.dashboard');
            }
            return redirect()->route('reader.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $loginInput = trim($request->input('email'));
        $password = (string) $request->input('password');
        $remember = $request->filled('remember');

        // Find user by email or phone
        $user = User::where('email', $loginInput)
            ->orWhere('phone', $loginInput)
            ->first();

        // Admin login shortcuts / domain variations
        if (!$user && in_array(strtolower($loginInput), ['admin', 'admin@muktadarboighor.com', 'info@muktadarboighor.com', 'admin@muktadasbookhouse.com'])) {
            $user = User::where('role', 'admin')->first();
        }

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->isPublisher()) {
                return redirect()->route('publisher.dashboard');
            }
            return redirect()->intended(route('reader.dashboard'));
        }

        return back()->withErrors([
            'email' => 'ইমেইল/ফোন অথবা পাসওয়ার্ড সঠিক নয়। আবার চেষ্টা করুন।',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('reader.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        Auth::login($user);

        return redirect()->route('reader.dashboard')->with('success', 'স্বাগতম! আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে।');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'আপনি সফলভাবে লগআউট হয়েছেন।');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'আপনার জিমেইল / ইমেইল অ্যাড্রেসটি দিন।',
            'email.email' => 'সঠিক ইমেইল ফরম্যাট দিন।',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'এই ইমেইল দিয়ে কোনো অ্যাকাউন্ট খুঁজে পাওয়া যায়নি।',
            ])->withInput();
        }

        // Generate Secure Token
        $token = \Illuminate\Support\Str::random(64);

        // Delete existing reset tokens for this email
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        // Store new token
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\ResetPasswordMail($user, $resetUrl));
            return back()->with('status', 'আপনার ইমেইলে পাসওয়ার্ড রিসেট লিংক পাঠানো হয়েছে! অনুগ্রহ করে আপনার ইনবক্স অথবা স্প্যাম (Spam) ফোল্ডার চেক করুন।');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Mail send error: ' . $e->getMessage());
            return back()->withErrors([
                'email' => 'ইমেইল পাঠানো যায়নি: ' . $e->getMessage() . '। অনুগ্রহ করে অ্যাডমিনকে জানান বা কাস্টমার সাপোর্টে যোগাযোগ করুন।'
            ]);
        }
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'ইমেইল অ্যাড্রেসটি প্রয়োজন।',
            'password.required' => 'নতুন পাসওয়ার্ড দিন।',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
        ]);

        $record = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'পাসওয়ার্ড রিসেট লিংকটি ভুল অথবা মেয়াদ শেষ হয়ে গেছে। আবার চেষ্টা করুন।']);
        }

        // Check if token expired (60 minutes)
        if (\Carbon\Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'এই রিসেট লিংকটির মেয়াদ শেষ হয়ে গেছে। দয়া করে নতুন করে লিংক চান।']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'কোনো ইউজার অ্যাকাউন্ট খুঁজে পাওয়া যায়নি।']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Delete token
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'আপনার পাসওয়ার্ড সফলভাবে পরিবর্তিত হয়েছে! এখন নতুন পাসওয়ার্ড দিয়ে লগইন করুন।');
    }
}
