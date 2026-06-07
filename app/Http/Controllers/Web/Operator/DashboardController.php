<?php

namespace App\Http\Controllers\Web\Operator;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama milik operator beserta statistik & log global
     */
    public function index()
    {
        // 1. Hitung total data riil dari database sekolah secara dinamis
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalKelas = DB::table('kelas')->count(); // Menghitung total baris dari tabel kelas Anda

        // 2. Ambil 5 catatan log aktivitas terbaru untuk radar pengawasan operator
        $logs = LogAktivitas::with('user')->latest()->take(5)->get();

        // 3. Kirim semua variabel ke file blade operator.dashboard
        return view('operator.dashboard', compact('totalGuru', 'totalSiswa', 'totalKelas', 'logs'));
    }
}
