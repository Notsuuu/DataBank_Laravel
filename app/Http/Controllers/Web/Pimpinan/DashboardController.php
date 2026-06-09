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
        // 1. Hitung jumlah total data
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();

        // 2. Logika persentase kelengkapan berkas
        // Kita hitung guru yang sudah upload KTP DAN Ijazah
        $berkasLengkap = Guru::whereNotNull('file_ktp')
                             ->whereNotNull('file_ijazah')
                             ->count();
        
        $persenKelengkapan = $totalGuru > 0 ? ($berkasLengkap / $totalGuru) * 100 : 0;

        // 3. Tarik log aktivitas terbaru (diperbanyak menjadi 10 agar lebih informatif)
        $logs = LogAktivitas::with('user')->latest()->take(10)->get();

        // 4. Kirim variabel ke view
        return view('pimpinan.dashboard', compact('totalGuru', 'totalSiswa', 'logs', 'persenKelengkapan'));
    }
}