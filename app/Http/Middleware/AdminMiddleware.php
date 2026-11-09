<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isStaff()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            return redirect()->route('login')->with('error', 'অ্যাডমিন প্যানেলে প্রবেশের জন্য উপযুক্ত অ্যাকাউন্টে লগইন করুন।');
        }

        return $next($request);
    }
}
