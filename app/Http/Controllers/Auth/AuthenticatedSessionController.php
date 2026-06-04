<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 1. Ambil role user yang sedang login
        $role = $request->user()->role;

        // 2. Tentukan rute dashboard berdasarkan role
        if ($role === 'operator') {
            $url = route('operator.dashboard', absolute: false);
        } elseif ($role === 'guru') {
            $url = route('guru.dashboard', absolute: false);
        } elseif ($role === 'pimpinan') {
            $url = route('pimpinan.dashboard', absolute: false);
        } else {
            $url = '/'; // Fallback jika user tidak punya role
        }

        // 3. Arahkan ke dashboard yang tepat!
        return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
