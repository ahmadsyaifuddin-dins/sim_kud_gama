<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login dan role-nya ada di dalam array $roles yang diizinkan
        if (! in_array($request->user()->role, $roles)) {
            // Jika tidak sesuai, lempar pesan error 403 Forbidden
            abort(403, 'Akses Ditolak! Halaman ini hanya untuk Administrator.');
        }

        return $next($request);
    }
}
