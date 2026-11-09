<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PublisherMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'পাবলিশার ড্যাশবোর্ডে প্রবেশের জন্য লগইন করুন।');
        }

        $user = Auth::user();

        if (!$user->isPublisher() && !$user->isAdmin()) {
            return redirect()->route('home')->with('error', 'আপনি পাবলিশার অ্যাকাউন্টে নিবন্ধিত নন।');
        }

        return $next($request);
    }
}
