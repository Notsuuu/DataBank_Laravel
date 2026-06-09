<?php

namespace App\Http\Controllers\Web\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;

class KinerjaController extends Controller
{
    public function index()
    {
        // Ambil semua data guru
        $gurus = Guru::all();
        $totalSkorKeseluruhan = 0;

        // Lakukan pemetaan data untuk kalkulasi skor secara real-time
        $daftarGuru = $gurus->map(function($guru) use (&$totalSkorKeseluruhan) {

            // Cek apakah guru ini sudah mengisi riwayat pendidikan minimum 1 data
            $hasPendidikan = DB::table('riwayat_pendidikans')
                ->where('guru_id', $guru->id)
                ->exists();

            // Algoritma Bobot Kepatuhan Administrasi (Masing-masing poin bernilai 25%)
            $skor = 0;
            if (!empty($guru->file_ktp)) $skor += 25;
            if (!empty($guru->file_ijazah)) $skor += 25;
            if (!empty($guru->file_sk)) $skor += 25;
            if ($hasPendidikan) $skor += 25;

            $guru->skor_kinerja = $skor;
            $totalSkorKeseluruhan += $skor;

            // Klasifikasi Predikat secara Visual
            if ($skor === 100) {
                $guru->predikat = 'Sangat Disiplin';
                $guru->badge = 'bg-emerald-100 text-emerald-700 border-emerald-200';
            } elseif ($skor >= 50) {
                $guru->predikat = 'Cukup Disiplin';
                $guru->badge = 'bg-amber-100 text-amber-700 border-amber-200';
            } else {
                $guru->predikat = 'Kurang Disiplin';
                $guru->badge = 'bg-rose-100 text-rose-700 border-rose-200';
            }

            return $guru;
        });

        // Hitung nilai rata-rata makro untuk sekolah
        $rataRata = $gurus->count() > 0 ? ($totalSkorKeseluruhan / $gurus->count()) : 0;

        return view('pimpinan.laporan_kinerja', compact('daftarGuru', 'rataRata'));
    }
}
