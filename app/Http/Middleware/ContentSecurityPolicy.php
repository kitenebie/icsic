<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://www.gstatic.com https://www.gstatic.com/firebasejs http://localhost:* https://localhost:*; " .
            "style-src 'self' 'unsafe-inline' https://fonts.bunny.net; " .
            "style-src-elem 'self' 'unsafe-inline' https://fonts.bunny.net; " .
            "script-src-elem 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
            "img-src 'self' data: https: blob: http://localhost:* https://localhost:*; " .
            "font-src 'self' https://fonts.bunny.net; " .
            "connect-src 'self' https://cdn.jsdelivr.net http://localhost:* https://localhost:* wss://localhost:*; " .
            "media-src 'self' blob: http://localhost:* https://localhost:*; " .
            "object-src 'none'; " .
            "frame-src 'none'; " .
            "base-uri 'self'; " .
            "form-action 'self';"
        );
        return $response;
    }
}
