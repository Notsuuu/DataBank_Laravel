<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Rombel;

class AkademikController extends Controller
{

    public function tahunAjaran()
    {
        $tahunAjarans = TahunAjaran::orderBy('tahun', 'desc')->get();
        return view('operator.akademik.tahun_ajaran', compact('tahunAjarans'));
    }

    public function storeTahunAjaran(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester'     => 'required|in:Ganjil,Genap',
        ]);

        $isActive = $request->has('is_active');
        if ($isActive) {
            TahunAjaran::where('is_active', true)->update(['is_active' => false]);
        }

        TahunAjaran::create([
            'tahun'     => $request->tahun_ajaran,
            'semester'  => $request->semester,
            'is_active' => $isActive,
        ]);

        return back()->with('success', 'Tahun Ajaran berhasil ditambahkan!');
    }

    public function editTahunAjaran($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        return view('operator.akademik.edit_tahun_ajaran', compact('ta'));
    }

    public function updateTahunAjaran(Request $request, $id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'semester'     => 'required|in:Ganjil,Genap',
        ]);

        $isActive = $request->has('is_active');
        if ($isActive) {
            TahunAjaran::where('id', '!=', $id)->where('is_active', true)->update(['is_active' => false]);
        }

        $ta->update([
            'tahun'     => $request->tahun_ajaran,
            'semester'  => $request->semester,
            'is_active' => $isActive,
        ]);

        return redirect()->route('akademik.tahun-ajaran')->with('success', 'Data Tahun Ajaran diperbarui!');
    }

    public function destroyTahunAjaran($id)
    {
        TahunAjaran::findOrFail($id)->delete();
        return back()->with('success', 'Data Tahun Ajaran berhasil dihapus!');
    }

    public function kelas()
    {
        $kelas = Kelas::with('waliKelas.user')->orderBy('tingkat_kelas')->orderBy('nama_kelas')->get();
        $gurus = Guru::with('user')->get();
        return view('operator.akademik.kelas', compact('kelas', 'gurus'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'tingkat_kelas' => 'required|string|max:10',
            'nama_kelas'    => 'required|string|max:50',
            'guru_id'       => 'nullable|exists:gurus,id'
        ]);

        Kelas::create($request->all());
        return back()->with('success', 'Data Kelas berhasil ditambahkan!');
    }

    public function editKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        $gurus = Guru::with('user')->get();
        return view('operator.akademik.edit_kelas', compact('kelas', 'gurus'));
    }

    public function updateKelas(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $request->validate([
            'tingkat_kelas' => 'required|string|max:10',
            'nama_kelas'    => 'required|string|max:50',
            'guru_id'       => 'nullable|exists:gurus,id'
        ]);

        $kelas->update($request->all());
        return redirect()->route('akademik.kelas')->with('success', 'Data Kelas diperbarui!');
    }

    public function destroyKelas($id)
    {
        Kelas::findOrFail($id)->delete();
        return back()->with('success', 'Data Kelas berhasil dihapus!');
    }

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

    public function editMapel($id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('operator.akademik.edit_mapel', compact('mapel'));
    }

    public function updateMapel(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);
        $request->validate([
            'kode_mapel'     => 'required|string|max:20|unique:mapels,kode_mapel,' . $id,
            'nama_mapel'     => 'required|string|max:100',
            'kelompok_mapel' => 'nullable|string|max:50'
        ]);

        $mapel->update([
            'kode_mapel'     => strtoupper($request->kode_mapel),
            'nama_mapel'     => $request->nama_mapel,
            'kelompok_mapel' => $request->kelompok_mapel,
        ]);

        return redirect()->route('akademik.mapel')->with('success', 'Mata Pelajaran diperbarui!');
    }

    public function destroyMapel($id)
    {
        Mapel::findOrFail($id)->delete();
        return back()->with('success', 'Mata Pelajaran berhasil dihapus!');
    }


    public function rombel(Request $request)
    {
        $tahunAktif = TahunAjaran::where('is_active', true)->first();
        $kelas = Kelas::orderBy('tingkat_kelas')->orderBy('nama_kelas')->get();
        $siswas = Siswa::orderBy('nama_lengkap')->get();

        $kelasId = $request->kelas_id;
        $rombels = collect();

        if ($tahunAktif && $kelasId) {
            $rombels = Rombel::with(['siswa', 'kelas'])->whereHas('siswa')->where('tahun_ajaran_id', $tahunAktif->id)->where('kelas_id', $kelasId)->get();
        }

        return view('operator.akademik.rombel', compact('tahunAktif', 'kelas', 'siswas', 'rombels', 'kelasId'));
    }

    public function storeRombel(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_id' => 'required|exists:siswas,id'
        ]);

        $tahunAktif = TahunAjaran::where('is_active', true)->first();
        if(!$tahunAktif) return back()->withErrors(['error' => 'Tidak ada Tahun Ajaran yang aktif!']);

        $exists = Rombel::where('tahun_ajaran_id', $tahunAktif->id)->where('siswa_id', $request->siswa_id)->exists();
        if($exists) return back()->withErrors(['error' => 'Siswa sudah terdaftar di kelas lain pada tahun ajaran ini.']);

        Rombel::create([
            'tahun_ajaran_id' => $tahunAktif->id,
            'kelas_id' => $request->kelas_id,
            'siswa_id' => $request->siswa_id
        ]);

        return redirect()->route('akademik.rombel', ['kelas_id' => $request->kelas_id])->with('success', 'Siswa berhasil dimasukkan ke kelas!');
    }

    public function hapusRombel($id)
    {
        $rombel = Rombel::findOrFail($id);
        $kelasId = $rombel->kelas_id;
        $rombel->delete();

        return redirect()->route('akademik.rombel', ['kelas_id' => $kelasId])->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }
}
