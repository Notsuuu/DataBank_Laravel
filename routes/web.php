<?php

use App\Http\Controllers\Web\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\GuruController;
use App\Http\Controllers\Web\SiswaController;
use App\Http\Controllers\Web\AkademikController;
use Illuminate\Support\Facades\Route;

// Rute Halaman Utama (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Semua rute di dalam grup ini wajib Login terlebih dahulu
Route::middleware('auth')->group(function () {

    // Rute Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // BENTENG 1: KHUSUS OPERATOR
    // ==========================================
    Route::middleware('role:operator')->group(function () {

        Route::get('/operator/dashboard', function () {
            return view('operator.dashboard');
        })->name('operator.dashboard');

        // M2: Manajemen Data Guru
        Route::get('/operator/guru', [GuruController::class, 'index'])->name('operator.guru.index');
        Route::get('/operator/guru/create', [GuruController::class, 'create'])->name('operator.guru.create');
        Route::post('/operator/guru', [GuruController::class, 'store'])->name('operator.guru.store');

        // M3: Manajemen Data Siswa
        Route::get('/operator/siswa', [SiswaController::class, 'index'])->name('operator.siswa.index');
        Route::get('/operator/siswa/create', [SiswaController::class, 'create'])->name('operator.siswa.create');
        Route::post('/operator/siswa', [SiswaController::class, 'store'])->name('operator.siswa.store');

        // M4: Manajemen Data Akademik
        Route::get('/operator/akademik/tahun-ajaran', [AkademikController::class, 'tahunAjaran'])->name('akademik.tahun-ajaran');
        Route::get('/operator/akademik/kelas', [AkademikController::class, 'kelas'])->name('akademik.kelas');
        Route::get('/operator/akademik/mapel', [AkademikController::class, 'mapel'])->name('akademik.mapel');
        Route::get('/operator/akademik/rombel', [AkademikController::class, 'rombel'])->name('akademik.rombel');

    });

    // ==========================================
    // BENTENG 2: KHUSUS GURU
    // ==========================================
    Route::middleware('role:guru')->group(function () {

        // PERBAIKAN: Mengarah langsung ke Controller agar data $user terkirim ke View
        Route::get('/guru/dashboard', [GuruDashboard::class, 'index'])->name('guru.dashboard');
        Route::get('/guru/pendidikan', [GuruDashboard::class, 'pendidikan'])->name('guru.pendidikan');
        Route::get('/guru/pendidikan/tambah', [GuruDashboard::class, 'createPendidikan'])->name('guru.pendidikan.create');
        Route::post('/guru/pendidikan', [GuruDashboard::class, 'storePendidikan'])->name('guru.pendidikan.store');
        Route::get('/guru/berkas', [GuruDashboard::class, 'berkas'])->name('guru.berkas');
        Route::get('/guru/berkas', [GuruDashboard::class, 'berkas'])->name('guru.berkas');
        Route::post('/guru/berkas/upload', [GuruDashboard::class, 'uploadBerkas'])->name('guru.berkas.upload');

        // Nanti menu seperti Input Nilai (M5) atau Presensi (M6) untuk web bisa ditaruh di sini

    });

    // ==========================================
    // BENTENG 3: KHUSUS PIMPINAN (Kepala Sekolah)
    // ==========================================
    Route::middleware('role:pimpinan')->group(function () {

        Route::get('/pimpinan/dashboard', function () {
            return view('pimpinan.dashboard');
        })->name('pimpinan.dashboard');

    });

});

// Memanggil sistem Routing Auth bawaan Breeze
require __DIR__.'/auth.php';
