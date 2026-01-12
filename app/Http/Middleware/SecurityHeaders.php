<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // ✅ Security Headers para proteção contra vários tipos de ataques
        return $response
            ->header('X-Content-Type-Options', 'nosniff')  // Previne MIME type sniffing
            ->header('X-Frame-Options', 'SAMEORIGIN')  // Previne clickjacking mas permite mesmo domínio
            ->header('X-XSS-Protection', '1; mode=block')  // Proteção XSS antiga (retrocompatibilidade)
            ->header('Referrer-Policy', 'strict-origin-when-cross-origin')  // Controla informações de referrer
            ->header('Permissions-Policy', 'geolocation=(), microphone=(), camera=()')  // Limita acesso a APIs sensíveis
            // Strict-Transport-Security apenas em HTTPS
            ->header('Strict-Transport-Security', $request->secure() ? 'max-age=31536000; includeSubDomains; preload' : '');
    }
}

