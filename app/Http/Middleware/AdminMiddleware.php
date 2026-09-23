<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan role-nya Admin (role_id == 1)
        if (!auth()->check() || auth()->user()->role_id !== 1) {
            abort(403, 'Akses Ditolak. Anda bukan Admin.');
        }

        return $next($request);
    }
}
