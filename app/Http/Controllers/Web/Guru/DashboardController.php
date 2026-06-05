<?php

namespace App\Http\Controllers\Web\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatPendidikan; // Sesuaikan jika nama modelmu berbeda
use Illuminate\Support\Facades\Auth;

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
        // Menampilkan riwayat khusus guru yang sedang login
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
            'jenjang'     => 'required|string|max:20',
            'institusi'   => 'required|string|max:255',
            'jurusan'     => 'required|string|max:255',
            'tahun_lulus' => 'required|digits:4|integer|min:1950|max:' . (date('Y') + 1),
        ]);

        RiwayatPendidikan::create([
            'guru_id'     => Auth::user()->guru->id,
            'jenjang'     => $request->jenjang,
            'institusi'   => $request->institusi,
            'jurusan'     => $request->jurusan,
            'tahun_lulus' => $request->tahun_lulus,
        ]);

        return redirect()->route('guru.pendidikan')->with('success', 'Riwayat pendidikan berhasil ditambahkan!');
    }

    // FUNGSI BARU: Edit Pendidikan
    public function editPendidikan($id)
    {
        // Pastikan hanya bisa mengedit data miliknya sendiri
        $pendidikan = RiwayatPendidikan::where('id', $id)
                        ->where('guru_id', Auth::user()->guru->id)
                        ->firstOrFail();

        return view('guru.pendidikan_edit', compact('pendidikan'));
    }

    // FUNGSI BARU: Update Pendidikan
    public function updatePendidikan(Request $request, $id)
    {
        $pendidikan = RiwayatPendidikan::where('id', $id)
                        ->where('guru_id', Auth::user()->guru->id)
                        ->firstOrFail();

        $request->validate([
            'jenjang'     => 'required|string|max:20',
            'institusi'   => 'required|string|max:255',
            'jurusan'     => 'required|string|max:255',
            'tahun_lulus' => 'required|digits:4|integer|min:1950|max:' . (date('Y') + 1),
        ]);

        $pendidikan->update([
            'jenjang'     => $request->jenjang,
            'institusi'   => $request->institusi,
            'jurusan'     => $request->jurusan,
            'tahun_lulus' => $request->tahun_lulus,
        ]);

        return redirect()->route('guru.pendidikan')->with('success', 'Riwayat pendidikan berhasil diperbarui!');
    }

    // FUNGSI BARU: Hapus Pendidikan
    public function destroyPendidikan($id)
    {
        $pendidikan = RiwayatPendidikan::where('id', $id)
                        ->where('guru_id', Auth::user()->guru->id)
                        ->firstOrFail();

        $pendidikan->delete();

        return redirect()->route('guru.pendidikan')->with('success', 'Riwayat pendidikan berhasil dihapus!');
    }

    // ==========================================
    // 3. KELOLA BERKAS
    // ==========================================
    public function berkas()
    {
        $user = Auth::user();
        $guru_id = $user->guru->id;

        // Ambil data dari tabel berkas_gurus dan ubah jadi array (contoh: ['ktp' => 'path/file.pdf'])
        $berkas = \Illuminate\Support\Facades\DB::table('berkas_gurus')
                    ->where('guru_id', $guru_id)
                    ->pluck('file_path', 'jenis_berkas')
                    ->toArray();

        // Kirim $user dan array $berkas ke view
        return view('guru.berkas', compact('user', 'berkas'));
    }

    public function uploadBerkas(Request $request)
    {
        $guru = Auth::user()->guru;

        $request->validate([
            'jenis_berkas' => 'required|in:ktp,ijazah,sk',
            'file_berkas'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $jenis = $request->jenis_berkas;
        $file = $request->file('file_berkas');

        // 1. Cek apakah berkas dengan jenis ini sudah ada di tabel berkas_gurus
        $berkasLama = \Illuminate\Support\Facades\DB::table('berkas_gurus')
                        ->where('guru_id', $guru->id)
                        ->where('jenis_berkas', $jenis)
                        ->first();

        // 2. Hapus file fisik lama di storage jika ada
        if ($berkasLama && $berkasLama->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($berkasLama->file_path);
        }

        // 3. Simpan file fisik yang baru
        $extension = $file->getClientOriginalExtension();
        $namaFile = 'scan_' . $jenis . '_' . time() . '.' . $extension;
        $path = $file->storeAs('berkas_guru/' . $guru->id, $namaFile, 'public');

        // 4. Masukkan ke database berkas_gurus (Update jika sudah ada, Insert jika belum)
        \Illuminate\Support\Facades\DB::table('berkas_gurus')->updateOrInsert(
            ['guru_id' => $guru->id, 'jenis_berkas' => $jenis], // Kunci pencarian
            ['file_path' => $path, 'created_at' => now(), 'updated_at' => now()] // Data yang diubah/dimasukkan
        );

        return back()->with('success', 'Berkas ' . strtoupper($jenis) . ' berhasil diperbarui!');
    }
}
