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
        
        // Check if this is an API request or should skip CSP
        if ($request->is('api/*') || $request->wantsJson()) {
            return $response;
        }

        // Build CSP policy based on environment
        $policy = $this->buildContentSecurityPolicy($request);
        
        $response->headers->set('Content-Security-Policy', $policy);
        
        // Also set Cross-Origin policies to be less restrictive for development
        if (app()->environment(['local', 'development'])) {
            $response->headers->set('Cross-Origin-Embedder-Policy', 'unsafe-none');
            $response->headers->set('Cross-Origin-Opener-Policy', 'unsafe-none');
        }
        
        return $response;
    }

    /**
     * Build the Content Security Policy based on environment and requirements
     */
    private function buildContentSecurityPolicy(Request $request): string
    {
        $isLocal = app()->environment(['local', 'development']);
        $host = $request->getHost();
        $scheme = $request->getScheme();
        
        // Base domains that are always allowed
        $trustedDomains = [
            'self',
            'https://cdn.jsdelivr.net',
            'https://cdnjs.cloudflare.com',
            'https://fonts.bunny.net',
            'https://fonts.gstatic.com',
            'https://www.gstatic.com',
        ];

        // Firebase and Google services
        $firebaseDomains = [
            'https://firebaseinstallations.googleapis.com',
            'https://fcm.googleapis.com',
            'https://firebase.googleapis.com',
            'https://www.googleapis.com',
            'https://*.googleapis.com',
            'https://firebase.google.com',
        ];

        // Face API and related services
        $faceApiDomains = [
            'https://cdn.jsdelivr.net',
            'https://github.com',
            'https://raw.githubusercontent.com',
            'https://*.github.io',
        ];

        // Image and media domains
        $mediaDomains = [
            'https://storage.googleapis.com',
            'https://*.googleusercontent.com',
            'https://images.unsplash.com',
            'https://*.unsplash.com',
        ];

        // Local development additions
        if ($isLocal) {
            $localDomains = [
                "http://localhost:*",
                "https://localhost:*",
                "http://127.0.0.1:*",
                "https://127.0.0.1:*",
                "http://{$host}:*",
                "https://{$host}:*",
            ];
            $trustedDomains = array_merge($trustedDomains, $localDomains);
            $firebaseDomains = array_merge($firebaseDomains, $localDomains);
            $mediaDomains = array_merge($mediaDomains, $localDomains);
        }

        // Combine all trusted domains
        $allTrustedDomains = array_unique(array_merge(
            $trustedDomains,
            $firebaseDomains,
            $faceApiDomains,
            $mediaDomains
        ));

        $trustedDomainsString = "'" . implode("' '", $allTrustedDomains) . "'";
        $trustedDomainsString = str_replace("''", "'", $trustedDomainsString); // Clean up any double quotes

        // Build the policy
        $policies = [
            // Default fallback - be more permissive for development
            "default-src " . ($isLocal ? "'self' 'unsafe-inline' 'unsafe-eval' " . $trustedDomainsString : "'self'"),

            // Scripts - allow inline for face detection and various CDNs
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' " . implode(' ', array_merge($trustedDomains, $faceApiDomains, $firebaseDomains)),

            // Script elements - same as script-src but for <script> tags
            "script-src-elem 'self' 'unsafe-inline' " . implode(' ', array_merge($trustedDomains, $faceApiDomains, $firebaseDomains)),

            // Styles - allow inline and font services
            "style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://fonts.googleapis.com https://cdn.jsdelivr.net",

            // Style elements - same as style-src but for <style> tags
            "style-src-elem 'self' 'unsafe-inline' https://fonts.bunny.net https://fonts.googleapis.com https://cdn.jsdelivr.net",

            // Images - allow data URLs, blob URLs, and various image services
            "img-src 'self' data: blob: https: http: " . implode(' ', $mediaDomains) . ($isLocal ? " http://localhost:* https://localhost:*" : ""),

            // Fonts
            "font-src 'self' data: https://fonts.bunny.net https://fonts.gstatic.com https://cdn.jsdelivr.net",

            // Connect - for API calls, WebSockets, etc.
            "connect-src 'self' " . implode(' ', array_merge($trustedDomains, $firebaseDomains, $mediaDomains)) . 
            ($isLocal ? " ws://localhost:* wss://localhost:* http://localhost:* https://localhost:*" : " wss:"),

            // Media - for camera, video, audio
            "media-src 'self' blob: data: https: " . ($isLocal ? "http://localhost:* https://localhost:*" : ""),

            // Child/Frame - be restrictive but allow some services if needed
            "child-src 'self' blob:",
            "frame-src 'self' blob:",

            // Worker - for web workers (some libraries use them)
            "worker-src 'self' blob:",

            // Object - generally restricted
            "object-src 'none'",

            // Base URI - restrict to self
            "base-uri 'self'",

            // Form actions - allow self
            "form-action 'self'",

            // Upgrade insecure requests in production
            app()->environment('production') ? "upgrade-insecure-requests" : "",
        ];

        // Filter out empty policies and join
        $policies = array_filter($policies, function($policy) {
            return !empty(trim($policy));
        });

        return implode('; ', $policies);
    }
}