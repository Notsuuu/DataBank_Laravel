<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pimpinan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Guru;

class PimpinanController extends Controller
{
    /**
     * Menampilkan daftar pimpinan
     */
    public function index(Request $request)
    {
        $query = Pimpinan::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->q . '%')
                ->orWhere('nip', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('status')) {
            $status = $request->status == '1' ? 'Aktif' : 'Nonaktif';
            $query->where('status_aktif', $status);
        }

        $para_pimpinan = $query->latest()->get();

        return view('operator.pimpinan.index', compact('para_pimpinan'));
    }

    /**
     * Menyimpan data pimpinan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id'
        ]);

        DB::beginTransaction();
        try {
            $guru = Guru::findOrFail($request->guru_id);
            $cekPimpinan = Pimpinan::where('user_id', $guru->user_id)->first();

            if ($cekPimpinan) {
                $cekPimpinan->update(['status_aktif' => 'Aktif']);
            } else {
                Pimpinan::create([
                    'user_id'        => $guru->user_id,
                    'nip'            => $guru->nip,
                    'gelar_depan'    => $guru->gelar_depan,
                    'nama_lengkap'   => $guru->nama_lengkap,
                    'gelar_belakang' => $guru->gelar_belakang,
                    'jenis_kelamin'  => $guru->jenis_kelamin,
                    'agama'          => $guru->agama,
                    'tempat_lahir'   => $guru->tempat_lahir,
                    'tanggal_lahir'  => $guru->tanggal_lahir,
                    'no_hp'          => $guru->no_hp,
                    'alamat'         => $guru->alamat,
                    'foto'           => $guru->foto,
                    'status_aktif'   => 'Aktif'
                ]);
            }   

            if ($guru->user) {
                $guru->user->update(['role' => 'pimpinan']);
            }

            DB::commit();
            return redirect()->route('operator.pimpinan.index')->with('success', 'Berhasil menambahkan guru ke jajaran Pimpinan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan form edit untuk data Pimpinan
     */
    public function edit(string $id)
    {
        $pimpinan = Pimpinan::with('user')->findOrFail($id);

        return view('operator.pimpinan.edit', compact('pimpinan'));
    }

    /**
     * Menampilkan form untuk menambah data Pimpinan baru
     */
    public function create()
    {
        $gurus = Guru::where('status_aktif', 'Aktif')->get();
        
        return view('operator.pimpinan.create', compact('gurus'));
    }

    /**
     * Update data pimpinan
     */
    public function update(Request $request, string $id)
    {
        $pimpinan = Pimpinan::findOrFail($id);

        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'agama'          => 'required|string',
            'tempat_lahir'   => 'required|string',
            'tanggal_lahir'  => 'required|date',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $fotoPath = $pimpinan->foto;
            if ($request->hasFile('foto')) {
                if ($pimpinan->foto && Storage::disk('public')->exists($pimpinan->foto)) {
                    Storage::disk('public')->delete($pimpinan->foto);
                }
                $fotoPath = $request->file('foto')->store('profil_pimpinan', 'public');
            }

            $statusString = $request->status_aktif == '1' ? 'Aktif' : 'Nonaktif';

            $pimpinan->update([
                'nip'            => $request->nip,
                'gelar_depan'    => $request->gelar_depan,
                'nama_lengkap'   => $request->nama_lengkap,
                'gelar_belakang' => $request->gelar_belakang,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'agama'          => $request->agama,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'no_hp'          => $request->no_hp,
                'alamat'         => $request->alamat,
                'foto'           => $fotoPath,
            ]);

            if ($pimpinan->user) {
                $pimpinan->user->update([
                    'name'      => $request->nama_lengkap,
                ]);
            }

            DB::commit();
            return redirect()->route('operator.pimpinan.index')->with('success', 'Data Profil Pimpinan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus / Nonaktifkan Pimpinan
     */
    public function destroy(string $id)
    {
        $pimpinan = Pimpinan::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($pimpinan->user) {
                $pimpinan->user->update([
                    'role'      => 'guru',
                    'is_active' => true
                ]);
            }

            $guru = Guru::where('user_id', $pimpinan->user_id)->first();

            if ($guru) {
                $guru->update(['status_aktif' => 'Aktif']);
            } else {
                Guru::create([
                    'user_id'        => $pimpinan->user_id,
                    'nip'            => $pimpinan->nip,
                    'nama_lengkap'   => $pimpinan->nama_lengkap,
                    'gelar_depan'    => $pimpinan->gelar_depan,
                    'gelar_belakang' => $pimpinan->gelar_belakang,
                    'jenis_kelamin'  => $pimpinan->jenis_kelamin,
                    'agama'          => $pimpinan->agama,
                    'tempat_lahir'   => $pimpinan->tempat_lahir,
                    'tanggal_lahir'  => $pimpinan->tanggal_lahir,
                    'no_hp'          => $pimpinan->no_hp,
                    'alamat'         => $pimpinan->alamat,
                    'foto'           => $pimpinan->foto,
                    'file_ktp'       => $pimpinan->file_ktp,
                    'file_ijazah'    => $pimpinan->file_ijazah,
                    'file_sk'        => $pimpinan->file_sk,
                    'status_aktif'   => 'Aktif'
                ]);
            }

            $pimpinan->update(['status_aktif' => 'Nonaktif']);

            DB::commit();
            return redirect()->route('operator.pimpinan.index')->with('success', 'Pimpinan telah dinonaktifkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}