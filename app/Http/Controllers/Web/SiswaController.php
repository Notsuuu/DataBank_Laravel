<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas; // Tambahkan ini untuk mengambil data dropdown kelas
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
        
        // 2. Ambil data semua kelas untuk mengisi dropdown di View
        $semuaKelas = Kelas::all(); 

        // 3. Buat query dasar dengan urutan abjad (bawaan temanmu)
        $query = Siswa::orderBy('nama_lengkap', 'asc');

        // 4. Logika Pencarian (Nama Lengkap atau NISN)
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('nama_lengkap', 'LIKE', "%{$keyword}%")
                  ->orWhere('nisn', 'LIKE', "%{$keyword}%");
            });
        }
        
        // 5. Logika Filter Kelas
        if ($kelasFilter) {
            $query->where('kelas_id', $kelasFilter);
        }

        // 6. Eksekusi query (Menggunakan paginate dari kamu agar tabel rapi, variabel dari temanmu)
        $siswas = $query->paginate(10);

        // 7. Arahkan ke view milik temanmu, kirimkan juga parameter filternya
        return view('operator.siswa.index', compact('siswas', 'keyword', 'kelasFilter', 'semuaKelas'));
    }

    public function create()
    {
        return view('operator.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'           => 'required|string|max:20|unique:siswas,nis',
            'nisn'          => 'nullable|string|max:20|unique:siswas,nisn',
            'nama_lengkap'  => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required|string|max:20',
            'alamat'        => 'nullable|string',
            'nama_wali'     => 'nullable|string|max:255',
            'no_hp_wali'    => 'nullable|string|max:15',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
            'nis'           => 'required|string|max:20|unique:siswas,nis,' . $siswa->id,
            'nisn'          => 'nullable|string|max:20|unique:siswas,nisn,' . $siswa->id,
            'nama_lengkap'  => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required|string|max:20',
            'alamat'        => 'nullable|string',
            'nama_wali'     => 'nullable|string|max:255',
            'no_hp_wali'    => 'nullable|string|max:15',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($siswa->foto) { Storage::disk('public')->delete($siswa->foto); }

            $extension = $request->file('foto')->getClientOriginalExtension();
            $namaFoto = 'siswa_' . $request->nis . '_' . time() . '.' . $extension;
            $data['foto'] = $request->file('foto')->storeAs('foto_siswa', $namaFoto, 'public');
        }

        $siswa->update($data);
        return redirect()->route('operator.siswa.index')->with('success', 'Data Siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        if ($siswa->foto) { Storage::disk('public')->delete($siswa->foto); }
        $siswa->delete();
        return back()->with('success', 'Data Siswa berhasil dihapus permanen!');
    }
}