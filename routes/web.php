<?php

use App\Http\Controllers\Web\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\GuruController;
use App\Http\Controllers\Web\SiswaController;
use App\Http\Controllers\Web\LaporanController;
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
        Route::get('/operator/guru/{id}/edit', [GuruController::class, 'edit'])->name('operator.guru.edit');
        Route::put('/operator/guru/{id}', [GuruController::class, 'update'])->name('operator.guru.update');
        Route::delete('/operator/guru/{id}', [GuruController::class, 'destroy'])->name('operator.guru.destroy');

        // M3: Manajemen Data Siswa (Di sini kamu tinggal sisipkan logika search nanti)
        Route::get('/operator/siswa', [SiswaController::class, 'index'])->name('operator.siswa.index');
        Route::get('/operator/siswa/create', [SiswaController::class, 'create'])->name('operator.siswa.create');
        Route::post('/operator/siswa', [SiswaController::class, 'store'])->name('operator.siswa.store');
        Route::get('/operator/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('operator.siswa.edit');
        Route::put('/operator/siswa/{id}', [SiswaController::class, 'update'])->name('operator.siswa.update');
        Route::delete('/operator/siswa/{id}', [SiswaController::class, 'destroy'])->name('operator.siswa.destroy');

        // M4: Manajemen Data Akademik
        Route::get('/operator/akademik/tahun-ajaran', [AkademikController::class, 'tahunAjaran'])->name('akademik.tahun-ajaran');
        Route::post('/operator/akademik/tahun-ajaran', [AkademikController::class, 'storeTahunAjaran'])->name('akademik.tahun-ajaran.store');
        Route::get('/operator/akademik/tahun-ajaran/{id}/edit', [AkademikController::class, 'editTahunAjaran'])->name('akademik.tahun-ajaran.edit');
        Route::put('/operator/akademik/tahun-ajaran/{id}', [AkademikController::class, 'updateTahunAjaran'])->name('akademik.tahun-ajaran.update');
        Route::delete('/operator/akademik/tahun-ajaran/{id}', [AkademikController::class, 'destroyTahunAjaran'])->name('akademik.tahun-ajaran.destroy');

        Route::get('/operator/akademik/kelas', [AkademikController::class, 'kelas'])->name('akademik.kelas');
        Route::post('/operator/akademik/kelas', [AkademikController::class, 'storeKelas'])->name('akademik.kelas.store');
        Route::get('/operator/akademik/kelas/{id}/edit', [AkademikController::class, 'editKelas'])->name('akademik.kelas.edit');
        Route::put('/operator/akademik/kelas/{id}', [AkademikController::class, 'updateKelas'])->name('akademik.kelas.update');
        Route::delete('/operator/akademik/kelas/{id}', [AkademikController::class, 'destroyKelas'])->name('akademik.kelas.destroy');

        Route::get('/operator/akademik/mapel', [AkademikController::class, 'mapel'])->name('akademik.mapel');
        Route::post('/operator/akademik/mapel', [AkademikController::class, 'storeMapel'])->name('akademik.mapel.store');
        Route::get('/operator/akademik/mapel/{id}/edit', [AkademikController::class, 'editMapel'])->name('akademik.mapel.edit');
        Route::put('/operator/akademik/mapel/{id}', [AkademikController::class, 'updateMapel'])->name('akademik.mapel.update');
        Route::delete('/operator/akademik/mapel/{id}', [AkademikController::class, 'destroyMapel'])->name('akademik.mapel.destroy');

        Route::get('/operator/akademik/rombel', [AkademikController::class, 'rombel'])->name('akademik.rombel');
        Route::post('/operator/akademik/rombel/store', [AkademikController::class, 'storeRombel'])->name('akademik.rombel.store');
        Route::delete('/operator/akademik/rombel/{id}', [AkademikController::class, 'hapusRombel'])->name('akademik.rombel.destroy');

        Route::get('/operator/laporan/guru/excel', [LaporanController::class, 'exportGuruExcel'])->name('operator.laporan.guru.excel');
        Route::post('/operator/guru/import', [LaporanController::class, 'importGuru'])->name('operator.guru.import');

    });

    // ==========================================
    // BENTENG 2: KHUSUS GURU
    // ==========================================
    Route::middleware('role:guru')->group(function () {

        Route::get('/guru/dashboard', [GuruDashboard::class, 'index'])->name('guru.dashboard');
        Route::get('/guru/pendidikan', [GuruDashboard::class, 'pendidikan'])->name('guru.pendidikan');
        Route::get('/guru/pendidikan/tambah', [GuruDashboard::class, 'createPendidikan'])->name('guru.pendidikan.create');
        Route::post('/guru/pendidikan', [GuruDashboard::class, 'storePendidikan'])->name('guru.pendidikan.store');
        Route::get('/guru/berkas', [GuruDashboard::class, 'berkas'])->name('guru.berkas');
        Route::post('/guru/berkas/upload', [GuruDashboard::class, 'uploadBerkas'])->name('guru.berkas.upload');

        // PERBAIKAN: Menggunakan GuruDashboard untuk Edit & Delete (M4)
        Route::get('/guru/pendidikan/{id}/edit', [GuruDashboard::class, 'editPendidikan'])->name('guru.pendidikan.edit');
        Route::put('/guru/pendidikan/{id}', [GuruDashboard::class, 'updatePendidikan'])->name('guru.pendidikan.update');
        Route::delete('/guru/pendidikan/{id}', [GuruDashboard::class, 'destroyPendidikan'])->name('guru.pendidikan.destroy');
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
