<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pimpinan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'email'          => 'required|email|unique:users,email',
            'nama_lengkap'   => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'agama'          => 'required|string',
            'tempat_lahir'   => 'required|string',
            'tanggal_lahir'  => 'required|date',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'password' => Hash::make($request->nip ?? 'pimpinan123'),
                'role'     => 'pimpinan',
                'force_change_password' => true
            ]);

            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('profil_pimpinan', 'public');
            }

            Pimpinan::create([
                'user_id'        => $user->id,
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
                'status_aktif'   => 'Aktif'
            ]);

            DB::commit();
            return redirect()->route('operator.pimpinan.index')->with('success', 'Data Pimpinan berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan form edit untuk data Pimpinan
     */
    public function edit($id)
    {
        $pimpinan = Pimpinan::with('user')->findOrFail($id);

        return view('operator.pimpinan.edit', compact('pimpinan'));
    }

    /**
     * Menampilkan form untuk menambah data Pimpinan baru
     */
    public function create()
    {
        return view('operator.pimpinan.create');
    }

    /**
     * Update data pimpinan
     */
    public function update(Request $request, $id)
    {
        $pimpinan = Pimpinan::findOrFail($id);

        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'agama'          => 'required|string',
            'tempat_lahir'   => 'required|string',
            'tanggal_lahir'  => 'required|date',
            'status_aktif'   => 'required|in:1,0',
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
                'status_aktif'   => $statusString
            ]);

            if ($pimpinan->user) {
                $pimpinan->user->update([
                    'name'      => $request->nama_lengkap,
                    'is_active' => $request->status_aktif == '1' ? true : false
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
    public function destroy($id)
    {
        $pimpinan = Pimpinan::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($pimpinan->user) {
                $pimpinan->user->update([
                    'role'      => 'guru',
                    'is_active' => false
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