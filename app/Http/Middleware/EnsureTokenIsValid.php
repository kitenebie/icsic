<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow public routes without any checks
        if ($request->is('login') || $request->is('register') || $request->routeIs('password.request')) {
            return $next($request);
        }

        // Handle logout - should work regardless of auth state
        if ($request->is('logout')) {
            return $next($request);
        }

        // Handle OTP routes
        if ($request->is('otp') || in_array($request->route()?->getName(), ['otpVerify'])) {
            // If not logged in, redirect to login
            if (!Auth::check()) {
                return redirect('/login');
            }
            
            // If already verified, redirect away from OTP
            if (Auth::user()->email_verified_at !== null) {
                return redirect('/');
            }
            
            return $next($request);
        }

        // If not logged in, redirect to login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // From here on, user is authenticated
        $user = Auth::user();

        // Handle waiting page - allow pending users
        if ($request->is('waiting')) {
            return $next($request);
        }

        // Check for pending role first (before email verification)
        if ($user->role === 'pending') {
            return redirect('/waiting');
        }

        // If logged in but email not verified, redirect to OTP
        if ($user->email_verified_at === null) {
            return redirect('/otp');
        }

        // Handle protected routes that require full verification
        if ($request->is('events') || $request->is('announcements')) {
            // User is authenticated and verified at this point, allow access
            return $next($request);
        }

        // Allow all other requests for verified users
        return $next($request);
    }
}