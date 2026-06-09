<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\GuruController;
use App\Http\Controllers\Web\SiswaController;
use App\Http\Controllers\Web\LaporanController;
use App\Http\Controllers\Web\AkademikController;
use App\Http\Controllers\Web\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Web\Pimpinan\DashboardController as PimpinanDashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ForceChangePassword;

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
    Route::get('/wajib-ganti-sandi', [ProfileController::class, 'forceChangePasswordForm'])->name('password.force.change');
    Route::post('/wajib-ganti-sandi', [ProfileController::class, 'forceUpdatePassword'])->name('password.force.update');

    // ==========================================
    // BENTENG 1: KHUSUS OPERATOR
    // ==========================================
    Route::middleware('role:operator')->group(function () {
        Route::get('/operator/dashboard', [App\Http\Controllers\Web\Operator\DashboardController::class, 'index'])->name('operator.dashboard');

        // M2: Manajemen Data Guru
        Route::get('/operator/guru', [GuruController::class, 'index'])->name('operator.guru.index');
        Route::get('/operator/guru/create', [GuruController::class, 'create'])->name('operator.guru.create');
        Route::post('/operator/guru', [GuruController::class, 'store'])->name('operator.guru.store');
        Route::get('/operator/guru/{id}/edit', [GuruController::class, 'edit'])->name('operator.guru.edit');
        Route::put('/operator/guru/{id}', [GuruController::class, 'update'])->name('operator.guru.update');
        Route::delete('/operator/guru/{id}', [GuruController::class, 'destroy'])->name('operator.guru.destroy');
        Route::get('/operator/laporan/guru/excel', [LaporanController::class, 'exportGuruExcel'])->name('operator.laporan.guru.excel');
        Route::post('/operator/guru/import', [LaporanController::class, 'importGuru'])->name('operator.guru.import');

        // M3: Manajemen Data Siswa
        Route::get('/operator/siswa', [SiswaController::class, 'index'])->name('operator.siswa.index');
        Route::get('/operator/siswa/create', [SiswaController::class, 'create'])->name('operator.siswa.create');
        Route::post('/operator/siswa', [SiswaController::class, 'store'])->name('operator.siswa.store');
        Route::get('/operator/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('operator.siswa.edit');
        Route::put('/operator/siswa/{id}', [SiswaController::class, 'update'])->name('operator.siswa.update');
        Route::delete('/operator/siswa/{id}', [SiswaController::class, 'destroy'])->name('operator.siswa.destroy');
        Route::get('/operator/laporan/siswa/excel', [LaporanController::class, 'exportSiswaExcel'])->name('operator.laporan.siswa.excel');
        Route::post('/operator/siswa/import', [LaporanController::class, 'importSiswa'])->name('operator.siswa.import');

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

    });

    // ==========================================
    // BENTENG 2: KHUSUS GURU
    // ==========================================
    Route::middleware(['role:guru', ForceChangePassword::class])
        ->prefix('guru')
        ->name('guru.')
        ->group(function () {
            Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');

            Route::get('/profil', [GuruDashboard::class, 'profil'])->name('profil');
            Route::put('/profil/update', [GuruDashboard::class, 'updateProfil'])->name('profil.update');

            // CRUD Riwayat Pendidikan
            Route::get('/pendidikan', [GuruDashboard::class, 'pendidikan'])->name('pendidikan');
            Route::get('/pendidikan/tambah', [GuruDashboard::class, 'createPendidikan'])->name('pendidikan.create');
            Route::post('/pendidikan', [GuruDashboard::class, 'storePendidikan'])->name('pendidikan.store');
            Route::get('/pendidikan/{id}/edit', [GuruDashboard::class, 'editPendidikan'])->name('pendidikan.edit');
            Route::put('/pendidikan/{id}', [GuruDashboard::class, 'updatePendidikan'])->name('pendidikan.update');
            Route::delete('/pendidikan/{id}', [GuruDashboard::class, 'destroyPendidikan'])->name('pendidikan.destroy');

            // Kelola Berkas Dokumen
            Route::get('/berkas', [GuruDashboard::class, 'berkas'])->name('berkas');
            Route::post('/berkas/upload', [GuruDashboard::class, 'uploadBerkas'])->name('berkas.upload');

            // Log Aktivitas Personal Guru (Disamakan strukturnya dengan menu layouts)
            Route::get('/log-aktivitas', [GuruDashboard::class, 'logAktivitas'])->name('log-aktivitas');
        });

    // ==========================================
    // BENTENG 3: KHUSUS PIMPINAN (Kepala Sekolah)
    // ==========================================
        Route::middleware(['role:pimpinan', ForceChangePassword::class])
        ->prefix('pimpinan')
        ->name('pimpinan.')
        ->group(function () {
            // PERBAIKAN FIXED: Mengarahkan kueri ke PimpinanDashboard agar data terhitung riil
            Route::get('/dashboard', [PimpinanDashboard::class, 'index'])->name('dashboard');
        });
});

// Memanggil sistem Routing Auth bawaan Breeze
require __DIR__ . '/auth.php';
