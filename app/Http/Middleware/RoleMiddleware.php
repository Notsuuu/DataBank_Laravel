<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Jika belum login sama sekali, lempar ke form login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Jika sudah login, tapi rolenya tidak cocok dengan rute yang diminta
        if (Auth::user()->role !== $role) {
            abort(403, 'AKSES DITOLAK: Anda tidak memiliki izin untuk melihat halaman ini.');
        }

        // Lolos pemeriksaan, silakan lewat!
        return $next($request);
    }
}
