<?php

namespace App\Http\Controllers\Web\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\RiwayatPendidikan;
use App\Models\BerkasGuru;

class DashboardController extends Controller
{
    /**
     * Menampilkan Halaman Ringkasan Profil Guru
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('guru');

        return view('guru.dashboard', compact('user'));
    }

    /**
     * Menampilkan Halaman Riwayat Pendidikan
     */
    public function pendidikan()
    {
        // Ambil data user, profil guru, BESERTA riwayat pendidikannya (diurutkan dari tahun lulus terbaru)
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load(['guru.riwayatPendidikan' => function($query) {
            $query->orderBy('tahun_lulus', 'desc');
        }]);

        return view('guru.pendidikan', compact('user'));
    }

    /**
     * Menampilkan Form Tambah Riwayat Pendidikan
     */
    public function createPendidikan()
    {
        return view('guru.pendidikan_create');
    }

    /**
     * Menyimpan Data Riwayat Pendidikan Baru
     */
    public function storePendidikan(Request $request)
    {
        $request->validate([
            'jenjang'     => 'required|string|max:50',
            'institusi'   => 'required|string|max:255',
            'jurusan'     => 'required|string|max:255',
            'tahun_lulus' => 'required|digits:4|integer|min:1950|max:' . (date('Y') + 5),
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

    /**
     * Menampilkan Halaman Pembaruan Berkas
     */
    public function berkas()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('guru.berkas');

        // Mengubah data berkas menjadi array asosiatif (jenis_berkas => file_path) agar mudah dicek di tampilan
        $berkas = [];
        if ($user->guru && $user->guru->berkas) {
            $berkas = $user->guru->berkas->pluck('file_path', 'jenis_berkas')->toArray();
        }

        return view('guru.berkas', compact('user', 'berkas'));
    }

    /**
     * Menangani Proses Upload Berkas dengan Penamaan Khusus
     */
    public function uploadBerkas(Request $request)
    {
        $request->validate([
            'jenis_berkas' => 'required|in:ktp,ijazah,sk',
            'file_berkas'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Maks 5MB
        ]);

        $guruId = Auth::user()->guru->id;
        $jenis = $request->jenis_berkas;

        // 1. Dapatkan ekstensi asli file (pdf, jpg, png)
        $extension = $request->file('file_berkas')->getClientOriginalExtension();

        // 2. Petakan nama file yang rapi berdasarkan jenisnya
        $namaFileMap = [
            'ktp'    => 'scan_ktp_asli',
            'ijazah' => 'ijazah_terakhir',
            'sk'     => 'sk_pengangkatan'
        ];

        // Contoh hasil: scan_ktp_asli_1717551234.pdf
        $namaFileRapi = $namaFileMap[$jenis] . '_' . time() . '.' . $extension;

        // 3. Gunakan storeAs() untuk menyimpan dengan nama custom
        $path = $request->file('file_berkas')->storeAs(
            "berkas_guru/{$guruId}",
            $namaFileRapi,
            'public'
        );

        // Cari apakah berkas jenis ini sudah pernah diupload
        $berkasLama = BerkasGuru::where('guru_id', $guruId)->where('jenis_berkas', $jenis)->first();

        if ($berkasLama) {
            // Hapus file fisik lama agar storage tidak penuh
            Storage::disk('public')->delete($berkasLama->file_path);
            $berkasLama->update(['file_path' => $path]);
        } else {
            BerkasGuru::create([
                'guru_id'      => $guruId,
                'jenis_berkas' => $jenis,
                'file_path'    => $path,
            ]);
        }

        return back()->with('success', 'Dokumen berhasil diunggah dan diperbarui!');
    }
}
