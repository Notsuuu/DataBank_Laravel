<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Mapel;

class AkademikController extends Controller
{
    // ==========================================
    // TAHUN AJARAN
    // ==========================================
    public function tahunAjaran()
    {
        $tahunAjarans = TahunAjaran::orderBy('created_at', 'desc')->get();
        return view('operator.akademik.tahun_ajaran', compact('tahunAjarans'));
    }

    public function storeTahunAjaran(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester'     => 'required|in:Ganjil,Genap',
        ]);

        // Jika dicentang aktif, matikan semua tahun ajaran lain terlebih dahulu
        $isActive = $request->has('is_active');
        if ($isActive) {
            TahunAjaran::where('is_active', true)->update(['is_active' => false]);
        }

        TahunAjaran::create([
            'tahun'        => $request->tahun_ajaran,
            'semester'     => $request->semester,
            'is_active'    => $isActive,
        ]);

        return back()->with('success', 'Tahun Ajaran berhasil ditambahkan!');
    }

    // ==========================================
    // MANAJEMEN KELAS
    // ==========================================
    public function kelas()
    {
        // Ambil data kelas beserta relasi wali kelas (jika ada)
        $kelas = Kelas::with('waliKelas.user')->orderBy('tingkat_kelas')->orderBy('nama_kelas')->get();

        // Ambil data guru untuk dropdown pemilihan wali kelas
        $gurus = \App\Models\Guru::with('user')->get();

        return view('operator.akademik.kelas', compact('kelas', 'gurus'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'tingkat_kelas' => 'required|string|max:10',
            'nama_kelas'    => 'required|string|max:50',
            'guru_id'       => 'nullable|exists:gurus,id'
        ]);

        Kelas::create([
            'tingkat_kelas' => $request->tingkat_kelas,
            'nama_kelas'    => $request->nama_kelas,
            'guru_id'       => $request->guru_id,
        ]);

        return back()->with('success', 'Data Kelas berhasil ditambahkan!');
    }

    // ==========================================
    // MANAJEMEN MATA PELAJARAN (MAPEL)
    // ==========================================
    public function mapel()
    {
        $mapels = Mapel::orderBy('kelompok_mapel')->orderBy('nama_mapel')->get();
        return view('operator.akademik.mapel', compact('mapels'));
    }

    public function storeMapel(Request $request)
    {
        $request->validate([
            'kode_mapel'     => 'required|string|unique:mapels,kode_mapel|max:20',
            'nama_mapel'     => 'required|string|max:100',
            'kelompok_mapel' => 'nullable|string|max:50'
        ]);

        Mapel::create([
            'kode_mapel'     => strtoupper($request->kode_mapel),
            'nama_mapel'     => $request->nama_mapel,
            'kelompok_mapel' => $request->kelompok_mapel,
        ]);

        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }
    // (Biarkan kosong dulu, sekadar agar rute tidak error)
    public function rombel() { return "Halaman Rombel - Segera Hadir"; }
}
