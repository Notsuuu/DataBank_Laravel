<?php

namespace App\Http\Controllers\Web\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung kuantitas data riil secara langsung dari database
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();

        // Tarik 5 baris catatan aktivitas global terbaru untuk konsumsi pimpinan
        $logs = LogAktivitas::with('user')->latest()->take(5)->get();

        // Kirim semua variabel ke dalam file pimpinan/dashboard.blade.php
        return view('pimpinan.dashboard', compact('totalGuru', 'totalSiswa', 'logs'));
    }
}
