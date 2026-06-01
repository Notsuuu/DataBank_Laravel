<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\KelasController;



Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

// ==========================================
// RUTE MODUL UTAMA (Terproteksi Token)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {

    // Rute M2 - Data Guru
    Route::apiResource('guru', GuruController::class);

    // Rute M3 - Data Siswa
    Route::apiResource('siswa', SiswaController::class);

    // Rute M4 - Data Tahun Ajaran
    Route::apiResource('tahun-ajaran', TahunAjaranController::class);

    // Rute M5 - Data Kelas
    Route::apiResource('kelas', KelasController::class);
});
