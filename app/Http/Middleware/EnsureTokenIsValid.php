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
        if ($request->is('login') || $request->is('logout')) {
            return $this->applySecurityHeaders($next($request));
        }

        // Allow OTP route without redirection
        if (
            $request->is('otp') ||
            $request->is('logout') ||
            in_array($request->route()->getName(), ['otpVerify'])
        ) {
            if ($request->is('otp') && Auth::user() && Auth::user()->email_verified_at != null) {
                return redirect('/login');
            }
            return $this->applySecurityHeaders($next($request));
        }

        // If not logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        if ($request->is('waiting')) {
            return $this->applySecurityHeaders($next($request));
        }

        // If logged in but not verified
        if (Auth::user()->email_verified_at === null) {
            return redirect('/otp');
        }

        return $this->applySecurityHeaders($next($request));
    }

    /**
     * Apply security headers to the response.
     */
    protected function applySecurityHeaders(Response $response): Response
    {
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        $response->headers->set('Cross-Origin-Embedder-Policy', 'require-corp');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');

        return $response;
    }
}
