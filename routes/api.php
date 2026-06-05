<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\TahunAjaranController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\Api\RombelController;


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
