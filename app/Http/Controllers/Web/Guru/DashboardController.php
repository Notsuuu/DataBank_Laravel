<?php

namespace App\Http\Controllers\Web\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatPendidikan;
use App\Models\LogAktivitas; // Diimpor agar bisa membaca dan mencatat log
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    // 2. CRUD RIWAYAT PENDIDIKAN (Otomatis Terekam Via Observer)
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

        $pendidikan->update([
            'jenjang' => $request->jenjang,
            'institusi' => $request->institusi,
            'jurusan' => $request->jurusan,
            'tahun_lulus' => $request->tahun_lulus,
        ]);

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
    // 3. KELOLA BERKAS (Manual Log Karena Menggunakan Query Builder)
    // ==========================================
    public function berkas()
    {
        $user = Auth::user();
        $guru_id = $user->guru->id;

        $berkas = DB::table('berkas_gurus')->where('guru_id', $guru_id)->pluck('file_path', 'jenis_berkas')->toArray();

        return view('guru.berkas', compact('user', 'berkas'));
    }

    public function uploadBerkas(Request $request)
    {
        $guru = Auth::user()->guru;

        $request->validate([
            'jenis_berkas' => 'required|in:ktp,ijazah,sk',
            'file_berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $jenis = $request->jenis_berkas;
        $file = $request->file('file_berkas');

        $berkasLama = DB::table('berkas_gurus')->where('guru_id', $guru->id)->where('jenis_berkas', $jenis)->first();

        if ($berkasLama && $berkasLama->file_path) {
            Storage::disk('public')->delete($berkasLama->file_path);
        }

        $extension = $file->getClientOriginalExtension();
        $namaFile = 'scan_' . $jenis . '_' . time() . '.' . $extension;
        $path = $file->storeAs('berkas_guru/' . $guru->id, $namaFile, 'public');

        // Deteksi Aksi Log (UPDATE jika berkas lama ada, CREATE jika berkas baru kosong)
        $aksiLog = $berkasLama ? 'UPDATE' : 'CREATE';

        DB::table('berkas_gurus')->updateOrInsert(['guru_id' => $guru->id, 'jenis_berkas' => $jenis], ['file_path' => $path, 'created_at' => now(), 'updated_at' => now()]);

        // Pencatatan Log Manual Khusus Berkas (Sebab DB::table tidak memicu Eloquent Observer)
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => $aksiLog,
            'entitas' => 'Berkas Guru',
            'data_lama' => $berkasLama ? ['jenis' => $jenis, 'file' => $berkasLama->file_path] : null,
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
        // Menarik semua riwayat aktivitas dari guru yang sedang login untuk halaman linimasa
        $logs = LogAktivitas::where('user_id', Auth::id())->latest()->get();

        return view('guru.log_aktivitas', compact('logs'));
    }
}
