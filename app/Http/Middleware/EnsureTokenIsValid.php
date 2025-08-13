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

        // Allow OTP route without redirection
        if ($request->is('login')  || $request->is('logout')) {
            return $next($request);
        }
        // Allow OTP route without redirection
        if ($request->is('otp') ||  $request->is('logout') || in_array($request->route()->getName(), ['otpVerify'])) {
            if ($request->is('otp') && Auth::user()->email_verified_at != null) {
                return redirect('/login');
            }
            return $next($request);
        }
        // If not logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        if($request->is('pendding') && Auth::check() && Auth::user()->email_verified_at === null){
            return $next($request);
        }

        // If logged in but not verified
        if (Auth::user()->email_verified_at === null) {
            return redirect('/otp');
        }

        return $next($request);
    }
}
