<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Menampilkan halaman Daftar Siswa dengan Fitur Pencarian & Filter Kelas
     */
    public function index(Request $request)
    {
        $keyword = $request->input('q');
        $kelasFilter = $request->input('kelas');

        $semuaKelas = Kelas::all();
        $tahunAktif = TahunAjaran::where('is_active', true)->first();

        $query = Siswa::with(['kelas', 'rombels' => function ($q) use ($tahunAktif) {
            if ($tahunAktif) {
                $q->where('tahun_ajaran_id', $tahunAktif->id)->with('kelas');
            }
        }]);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_lengkap', 'LIKE', "%{$keyword}%")
                    ->orWhere('nisn', 'LIKE', "%{$keyword}%")
                    ->orWhere('nis', 'LIKE', "%{$keyword}%");
            });
        }

        if ($kelasFilter) {
            $query->where('kelas_id', $kelasFilter);
        }

        $query->orderBy('nama_lengkap', 'asc');

        $siswas = $query->paginate(10)->appends($request->query());

        return view('operator.siswa.index', compact('siswas', 'keyword', 'kelasFilter', 'semuaKelas'));
    }

    public function create()
    {
        $semuaKelas = Kelas::all();
        return view('operator.siswa.create', compact('semuaKelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:siswas,nis',
            'nisn' => 'nullable|string|max:20|unique:siswas,nisn',
            'nik' => 'nullable|string|max:20',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
                        
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            
            'no_hp_siswa' => 'nullable|string|max:20',
            
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            
            'kelas_id' => 'nullable|exists:kelas,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['foto']); 

        if ($request->hasFile('foto')) {
            $extension = $request->file('foto')->getClientOriginalExtension();
            $namaFoto = 'siswa_' . $request->nis . '_' . time() . '.' . $extension;
            $data['foto'] = $request->file('foto')->storeAs('foto_siswa', $namaFoto, 'public');
        }

        Siswa::create($data);
        return redirect()->route('operator.siswa.index')->with('success', 'Data Siswa berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $semuaKelas = Kelas::all(); 
        
        return view('operator.siswa.edit', compact('siswa', 'semuaKelas'));
    }

    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|string|max:20|unique:siswas,nis,' . $siswa->id,
            'nisn' => 'nullable|string|max:20|unique:siswas,nisn,' . $siswa->id,
            'nik' => 'nullable|string|max:20',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
            
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            
            'no_hp_siswa' => 'nullable|string|max:20',

            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            
            'kelas_id' => 'nullable|exists:kelas,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $extension = $request->file('foto')->getClientOriginalExtension();
            $namaFoto = 'siswa_' . $request->nis . '_' . time() . '.' . $extension;
            $data['foto'] = $request->file('foto')->storeAs('foto_siswa', $namaFoto, 'public');
        }

        $siswa->update($data);
        return redirect()->route('operator.siswa.index')->with('success', 'Data Profil Siswa berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->route('operator.siswa.index')->with('success', 'Data siswa berhasil dihapus secara permanen!');
    }
}