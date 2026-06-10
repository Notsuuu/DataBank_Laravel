<?php

namespace App\Http\Controllers\Web\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Pimpinan;
use App\Models\RiwayatPendidikan;
use App\Models\LogAktivitas;

class DashboardController extends Controller
{
    // ==========================================
    // 1. DASHBOARD & RINGKASAN
    // ==========================================
    public function index()
    {
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $logs = LogAktivitas::with('user')->latest()->take(5)->get();

        $gurus = Guru::all();
        $totalSkorKeseluruhan = 0;

        $daftarGuru = $gurus->map(function($guru) use (&$totalSkorKeseluruhan) {
            $hasPendidikan = DB::table('riwayat_pendidikans')->where('guru_id', $guru->id)->exists();
            $skor = 0;

            if (!empty($guru->file_ktp)) $skor += 25;
            if (!empty($guru->file_ijazah)) $skor += 25;
            if (!empty($guru->file_sk)) $skor += 25;
            if ($hasPendidikan) $skor += 25;

            $guru->skor_kinerja = $skor;
            $totalSkorKeseluruhan += $skor;

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

        $persenKelengkapan = $totalGuru > 0 ? ($totalSkorKeseluruhan / $totalGuru) : 0;

        return view('pimpinan.dashboard', compact('totalGuru', 'totalSiswa', 'persenKelengkapan', 'logs', 'daftarGuru'));
    }

    // ==========================================
    // 2. KELOLA PROFIL PIMPINAN
    // ==========================================
    public function profil()
    {
        $user = Auth::user();
        return view('pimpinan.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $pimpinan = $user->pimpinan;

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $dataUpdate = $request->only([
            'nama_lengkap', 'gelar_depan', 'gelar_belakang',
            'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
            'agama', 'no_hp', 'alamat'
        ]);

        if ($request->hasFile('foto')) {
            if ($pimpinan->foto && Storage::disk('public')->exists($pimpinan->foto)) {
                Storage::disk('public')->delete($pimpinan->foto);
            }
            $dataUpdate['foto'] = $request->file('foto')->store('foto_pimpinan', 'public');
        }

        $pimpinan->update($dataUpdate);
        $user->update(['name' => $request->nama_lengkap]);

        return back()->with('success', 'Data profil dan biodata berhasil diperbarui!');
    }

    // ==========================================
    // 3. CRUD RIWAYAT PENDIDIKAN PIMPINAN
    // ==========================================
    public function pendidikan()
    {
        // Pastikan model RiwayatPendidikan memiliki kolom pimpinan_id
        $riwayats = RiwayatPendidikan::where('pimpinan_id', Auth::user()->pimpinan->id)
            ->orderBy('tahun_lulus', 'desc')
            ->get();
        return view('pimpinan.pendidikan', compact('riwayats'));
    }

    public function createPendidikan()
    {
        return view('pimpinan.pendidikan_create');
    }

    public function storePendidikan(Request $request)
    {
        $request->validate([
            'jenjang' => 'required|string|max:20',
            'institusi' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'tahun_lulus' => 'required|digits:4|integer|min:1950|max:' . (date('Y') + 1),
        ]);

        RiwayatPendidikan::create([
            'pimpinan_id' => Auth::user()->pimpinan->id,
            'jenjang' => $request->jenjang,
            'institusi' => $request->institusi,
            'jurusan' => $request->jurusan,
            'tahun_lulus' => $request->tahun_lulus,
        ]);

        return redirect()->route('pimpinan.pendidikan')->with('success', 'Riwayat pendidikan berhasil ditambahkan!');
    }

    public function editPendidikan(string $id)
    {
        $pendidikan = RiwayatPendidikan::where('id', $id)
            ->where('pimpinan_id', Auth::user()->pimpinan->id)
            ->firstOrFail();

        return view('pimpinan.pendidikan_edit', compact('pendidikan'));
    }

    public function updatePendidikan(Request $request, string $id)
    {
        $pendidikan = RiwayatPendidikan::where('id', $id)
            ->where('pimpinan_id', Auth::user()->pimpinan->id)
            ->firstOrFail();

        $request->validate([
            'jenjang' => 'required|string|max:20',
            'institusi' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'tahun_lulus' => 'required|digits:4|integer|min:1950|max:' . (date('Y') + 1),
        ]);

        $pendidikan->update($request->only(['jenjang', 'institusi', 'jurusan', 'tahun_lulus']));

        return redirect()->route('pimpinan.pendidikan')->with('success', 'Riwayat pendidikan berhasil diperbarui!');
    }

    public function destroyPendidikan(string $id)
    {
        $pendidikan = RiwayatPendidikan::where('id', $id)
            ->where('pimpinan_id', Auth::user()->pimpinan->id)
            ->firstOrFail();

        $pendidikan->delete();

        return redirect()->route('pimpinan.pendidikan')->with('success', 'Riwayat pendidikan berhasil dihapus!');
    }

    // ==========================================
    // 4. KELOLA BERKAS PIMPINAN
    // ==========================================
    public function berkas()
    {
        $user = Auth::user();
        $pimpinan = $user->pimpinan;
        return view('pimpinan.berkas', compact('user', 'pimpinan'));
    }

    public function uploadBerkas(Request $request)
    {
        $pimpinan = Auth::user()->pimpinan;

        $request->validate([
            'jenis_berkas' => 'required|in:ktp,ijazah,sk',
            'file_berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $jenis = $request->jenis_berkas;
        $kolom = 'file_' . $jenis;
        $file = $request->file('file_berkas');

        $aksiLog = $pimpinan->$kolom ? 'UPDATE' : 'CREATE';

        if ($pimpinan->$kolom && Storage::disk('public')->exists($pimpinan->$kolom)) {
            Storage::disk('public')->delete($pimpinan->$kolom);
        }

        $path = $file->store('berkas_pimpinan/' . $pimpinan->id, 'public');

        $pimpinan->update([
            $kolom => $path
        ]);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => $aksiLog,
            'entitas' => 'Berkas Pimpinan',
            'data_baru' => [
                'jenis' => $jenis,
                'file' => $path,
                'nama' => 'Pembaruan Dokumen Resmi ' . strtoupper($jenis),
            ],
        ]);

        return back()->with('success', 'Berkas ' . strtoupper($jenis) . ' berhasil diperbarui!');
    }

    // ==========================================
    // LAPORAN KINERJA GURU
    // ==========================================
    public function laporanKinerja()
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
