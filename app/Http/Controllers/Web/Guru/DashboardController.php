<?php

namespace App\Http\Controllers\Web\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatPendidikan;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // ==========================================
    // 1. DASHBOARD & RINGKASAN
    // ==========================================
    public function index()
    {
        $user = Auth::user();
        return view('guru.dashboard', compact('user'));
    }

    // ==========================================
    // 2. CRUD RIWAYAT PENDIDIKAN
    // ==========================================
    public function pendidikan()
    {
        $riwayats = RiwayatPendidikan::where('guru_id', Auth::user()->guru->id)
            ->orderBy('tahun_lulus', 'desc')
            ->get();
        return view('guru.pendidikan', compact('riwayats'));
    }

    public function createPendidikan()
    {
        return view('guru.pendidikan_create');
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
            'guru_id' => Auth::user()->guru->id,
            'jenjang' => $request->jenjang,
            'institusi' => $request->institusi,
            'jurusan' => $request->jurusan,
            'tahun_lulus' => $request->tahun_lulus,
        ]);

        return redirect()->route('guru.pendidikan')->with('success', 'Riwayat pendidikan berhasil ditambahkan!');
    }

    public function editPendidikan($id)
    {
        $pendidikan = RiwayatPendidikan::where('id', $id)
            ->where('guru_id', Auth::user()->guru->id)
            ->firstOrFail();

        return view('guru.pendidikan_edit', compact('pendidikan'));
    }

    public function updatePendidikan(Request $request, $id)
    {
        $pendidikan = RiwayatPendidikan::where('id', $id)
            ->where('guru_id', Auth::user()->guru->id)
            ->firstOrFail();
        
        $request->validate([
            'jenjang' => 'required|string|max:20',
            'institusi' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'tahun_lulus' => 'required|digits:4|integer|min:1950|max:' . (date('Y') + 1),
        ]);

        $pendidikan->update($request->only(['jenjang', 'institusi', 'jurusan', 'tahun_lulus']));

        return redirect()->route('guru.pendidikan')->with('success', 'Riwayat pendidikan berhasil diperbarui!');
    }

    public function destroyPendidikan($id)
    {
        $pendidikan = RiwayatPendidikan::where('id', $id)
            ->where('guru_id', Auth::user()->guru->id)
            ->firstOrFail();

        $pendidikan->delete();

        return redirect()->route('guru.pendidikan')->with('success', 'Riwayat pendidikan berhasil dihapus!');
    }

    // ==========================================
    // 3. KELOLA BERKAS (Menggunakan Kolom di Tabel Gurus)
    // ==========================================
    public function berkas()
    {
        $user = Auth::user();
        $guru = $user->guru; 
        return view('guru.berkas', compact('user', 'guru'));
    }

    public function uploadBerkas(Request $request)
    {
        $guru = Auth::user()->guru;

        $request->validate([
            'jenis_berkas' => 'required|in:ktp,ijazah,sk',
            'file_berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $jenis = $request->jenis_berkas; // ktp, ijazah, atau sk
        $kolom = 'file_' . $jenis; // Hasilnya: file_ktp, file_ijazah, atau file_sk
        $file = $request->file('file_berkas');

        // Deteksi apakah ini update atau upload baru untuk Log
        $aksiLog = $guru->$kolom ? 'UPDATE' : 'CREATE';

        // Hapus file lama jika ada
        if ($guru->$kolom && Storage::disk('public')->exists($guru->$kolom)) {
            Storage::disk('public')->delete($guru->$kolom);
        }

        // Simpan file baru
        $path = $file->store('berkas_guru/' . $guru->id, 'public');

        // Update langsung ke tabel gurus
        $guru->update([
            $kolom => $path
        ]);

        // Catat Log Aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => $aksiLog,
            'entitas' => 'Berkas Guru',
            'data_baru' => [
                'jenis' => $jenis, 
                'file' => $path,
                'nama' => 'Pembaruan Dokumen Resmi ' . strtoupper($jenis),
            ],
        ]);

        return back()->with('success', 'Berkas ' . strtoupper($jenis) . ' berhasil diperbarui!');
    }

    // ==========================================
    // 4. LOG AKTIVITAS PERSONAL GURU
    // ==========================================
    public function logAktivitas()
    {
        $logs = LogAktivitas::where('user_id', Auth::id())->latest()->get();
        return view('guru.log_aktivitas', compact('logs'));
    }
}