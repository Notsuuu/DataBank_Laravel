<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran; // Wajib ditambahkan untuk mengecek tahun aktif
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Menampilkan halaman Daftar Siswa dengan Fitur Pencarian & Filter Kelas
     */
    public function index(Request $request)
    {
        // 1. Ambil parameter dari URL
        $keyword = $request->input('q');
        $kelasFilter = $request->input('kelas');

        // 2. Ambil data master untuk kebutuhan View dan Query
        $semuaKelas = Kelas::all();
        $tahunAktif = TahunAjaran::where('is_active', true)->first();

        // 3. Buat query dasar: Wajib sertakan relasi 'rombels' agar UI "Belum ada kelas" teratasi
        $query = Siswa::with([
            'rombels' => function ($q) use ($tahunAktif) {
                if ($tahunAktif) {
                    $q->where('tahun_ajaran_id', $tahunAktif->id)->with('kelas');
                }
            },
        ]);

        // 4. Logika Pencarian (Nama Lengkap, NISN, atau NIS)
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_lengkap', 'LIKE', "%{$keyword}%")
                    ->orWhere('nisn', 'LIKE', "%{$keyword}%")
                    ->orWhere('nis', 'LIKE', "%{$keyword}%"); // Ekstra: Bisa cari pakai NIS juga
            });
        }

        // 5. Logika Filter Kelas (DIperbaiki: Menggunakan whereHas karena relasi melalui Rombel)
        if ($kelasFilter && $tahunAktif) {
            $query->whereHas('rombels', function ($q) use ($kelasFilter, $tahunAktif) {
                $q->where('kelas_id', $kelasFilter)->where('tahun_ajaran_id', $tahunAktif->id);
            });
        }

        // 6. Urutkan berdasarkan abjad
        $query->orderBy('nama_lengkap', 'asc');

        // 7. Eksekusi query dengan paginate (DIperbaiki: Tambahkan appends agar filter tidak hilang di Page 2)
        $siswas = $query->paginate(10)->appends($request->query());

        // 8. Arahkan ke view
        return view('operator.siswa.index', compact('siswas', 'keyword', 'kelasFilter', 'semuaKelas'));
    }

    public function create()
    {
        return view('operator.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:siswas,nis',
            'nisn' => 'nullable|string|max:20|unique:siswas,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'nama_wali' => 'nullable|string|max:255',
            'no_hp_wali' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $extension = $request->file('foto')->getClientOriginalExtension();
            $namaFoto = 'siswa_' . $request->nis . '_' . time() . '.' . $extension;
            $data['foto'] = $request->file('foto')->storeAs('foto_siswa', $namaFoto, 'public');
        }

        Siswa::create($data);
        return redirect()->route('operator.siswa.index')->with('success', 'Data Siswa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('operator.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|string|max:20|unique:siswas,nis,' . $siswa->id,
            'nisn' => 'nullable|string|max:20|unique:siswas,nisn,' . $siswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'nama_wali' => 'nullable|string|max:255',
            'no_hp_wali' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $extension = $request->file('foto')->getClientOriginalExtension();
            $namaFoto = 'siswa_' . $request->nis . '_' . time() . '.' . $extension;
            $data['foto'] = $request->file('foto')->storeAs('foto_siswa', $namaFoto, 'public');
        }

        $siswa->update($data);
        return redirect()->route('operator.siswa.index')->with('success', 'Data Siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari data siswa
        $siswa = \App\Models\Siswa::findOrFail($id);

        // Hapus data (Menyerahkan pencatatan log otomatis ke Observer)
        $siswa->delete();

        return redirect()->route('operator.siswa.index')->with('success', 'Data siswa berhasil dihapus dari sistem!');
    }
}
