<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\RombelController;


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

    // Rute API
    Route::apiResource('guru', GuruController::class);
    Route::apiResource('siswa', SiswaController::class);
    Route::apiResource('tahun-ajaran', TahunAjaranController::class);
    Route::apiResource('kelas', KelasController::class);
    Route::apiResource('mapel', MapelController::class);
    Route::apiResource('rombel', RombelController::class)->except(['show', 'update']);
});
