<?php

namespace App\Http\Controllers\Web\Operator;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama milik operator beserta statistik laporan & log global
     */
    public function index()
    {
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalKelas = DB::table('kelas')->count();

        $guruPns = Guru::whereNotNull('nip')->where('nip', '!=', '')->count();
        $guruHonorer = Guru::where(function($q) {
            $q->whereNull('nip')->orWhere('nip', '');
        })->count();

        $siswaKelas7 = Siswa::whereHas('kelas', function($q) { $q->where('tingkat_kelas', '7'); })->count();
        $siswaKelas8 = Siswa::whereHas('kelas', function($q) { $q->where('tingkat_kelas', '8'); })->count();
        $siswaKelas9 = Siswa::whereHas('kelas', function($q) { $q->where('tingkat_kelas', '9'); })->count();

        $chartGuru = [$guruPns, $guruHonorer];
        $chartSiswa = [$siswaKelas7, $siswaKelas8, $siswaKelas9];

        $logs = LogAktivitas::with('user')->latest()->take(5)->get();

        return view('operator.dashboard', compact(
            'totalGuru', 
            'totalSiswa', 
            'totalKelas', 
            'chartGuru', 
            'chartSiswa', 
            'logs'
        ));
    }
}