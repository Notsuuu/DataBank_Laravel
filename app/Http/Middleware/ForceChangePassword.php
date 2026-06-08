<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceChangePassword
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->force_change_password) {
            
            if ($request->routeIs('password.force.*') || $request->routeIs('logout')) {
                return $next($request);
            }

            return redirect()->route('password.force.change')
                ->with('error', 'Keamanan: Anda wajib mengganti kata sandi default (NIP) sebelum bisa mengakses sistem.');
        }

        return $next($request);
    }
}