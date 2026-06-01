<?php

use Illuminate\Support\Facades\Route;

// Rute Halaman Utama (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Rute Halaman Login
Route::get('/login', function () {
    return view('auth.login');
});

// rute 3 Dashboard utama
Route::get('/operator/dashboard', function () { return view('operator.dashboard'); });
Route::get('/guru/dashboard', function () { return view('guru.dashboard'); });
Route::get('/pimpinan/dashboard', function () { return view('pimpinan.dashboard'); });
