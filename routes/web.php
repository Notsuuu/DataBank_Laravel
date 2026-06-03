<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rute Halaman Utama (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Rute Halaman Login
Route::get('/login', function () {
    return view('auth.login');
});

// Rute Proses Auth (Menuju Controller)
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// rute 3 Dashboard utama dengan middleware role untuk proteksi akses

Route::middleware('role:operator')->group(function () {
    Route::get('/operator/dashboard', function () { return view('operator.dashboard'); });
    Route::resource('/operator/guru', \App\Http\Controllers\operator\GuruController::class);
    Route::get('/operator/siswa', [App\Http\Controllers\operator\SiswaController::class, 'index']);
});

Route::middleware('role:guru')->group(function () {
    Route::get('/guru/dashboard', function () { return view('guru.dashboard'); });
});

Route::middleware('role:pimpinan')->group(function () {
    Route::get('/pimpinan/dashboard', function () { return view('pimpinan.dashboard'); });
});
