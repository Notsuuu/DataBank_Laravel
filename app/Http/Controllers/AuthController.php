<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Memproses percobaan login.
     */
    public function authenticate(Request $request)
    {
        // 1. Validasi input form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba cocokkan dengan database
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $user = Auth::user();

            // 3. Cek apakah akun aktif (is_active)
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.',
                ])->onlyInput('email');
            }

            // 4. Regenerasi session untuk mencegah Session Fixation attack
            $request->session()->regenerate();

            // 5. Redirect berdasarkan role (Gaya PHP 8)
            return match ($user->role) {
                'operator' => redirect()->intended('/operator/dashboard'),
                'guru'     => redirect()->intended('/guru/dashboard'),
                'pimpinan' => redirect()->intended('/pimpinan/dashboard'),
                default    => redirect('/'),
            };
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
