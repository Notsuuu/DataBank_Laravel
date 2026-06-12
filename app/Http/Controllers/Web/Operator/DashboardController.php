<?php

namespace App\Http\Controllers\Web\Operator;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Pimpinan;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama milik operator beserta statistik laporan & log global
     */
    public function index()
    {
        $queryGuruAktif = Guru::where('status_aktif', 'Aktif')
            ->whereHas('user', function ($q) {
                $q->where('role', 'guru');
            });

        $totalGuru = (clone $queryGuruAktif)->count();
        $totalPimpinan = Pimpinan::where('status_aktif', 'Aktif')->count();
        
        $totalSiswa = Siswa::count();
        $totalKelas = DB::table('kelas')->count();

        $guruPns = (clone $queryGuruAktif)->whereNotNull('nip')->where('nip', '!=', '')->count();
        $guruHonorer = (clone $queryGuruAktif)->where(function($q) {
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
            'totalPimpinan', 
            'chartGuru',
            'chartSiswa',
            'logs'
        ));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('operator.profil', compact('user'));
    }

    public function updateProfil(\Illuminate\Http\Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Data profil berhasil diperbarui!');
    }
}