<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuruExport;

class GuruController extends Controller
{
    /**
     * Menampilkan halaman Daftar Guru dengan Fitur Pencarian & Filter
     */
    public function index(Request $request)
    {
        $keyword = $request->input('q');
        $status = $request->input('status'); 
        $tingkatKelas = $request->input('kelas');

        $query = Guru::with(['user', 'kelas'])->latest();

        $query->whereHas('user', function ($q) {
            $q->where('role', 'guru');
        });

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_lengkap', 'LIKE', "%{$keyword}%")->orWhere('nip', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->has('status') && $status !== null) {
            $statusDbd = $request->input('status') == '1' ? 'Aktif' : 'Tidak Aktif';        
            $query->where('status_aktif', $statusDbd);
        }

        if ($tingkatKelas) {
            $tingkatRomawi = '';
            if ($tingkatKelas == '7') $tingkatRomawi = 'VII';
            if ($tingkatKelas == '8') $tingkatRomawi = 'VIII';
            if ($tingkatKelas == '9') $tingkatRomawi = 'IX';

            $query->whereHas('kelas', function ($q) use ($tingkatKelas, $tingkatRomawi) {
                $q->where('tingkat_kelas', $tingkatKelas)
                ->orWhere('tingkat_kelas', $tingkatRomawi);
            });
        }

        return view('operator.guru.index', [
            'para_guru' => $query->get(),
            'keyword' => $keyword,
            'status' => $status,
            'tingkatKelas' => $tingkatKelas,
        ]);
    }

    public function create()
    {
        return view('operator.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:guru,pimpinan',
            'nip' => 'nullable|unique:gurus,nip',
            'nama_lengkap' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string',  
            'no_hp' => 'nullable|string|max:20',
            'pangkat_gol' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'status_pegawai' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $defaultPassword = $request->nip ? $request->nip : 'guru123';

            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($defaultPassword),
                'role' => $request->role,
                'is_active' => true,
                'force_change_password' => true, 
            ]);

            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto_guru', 'public');
            }

            Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nama_lengkap' => $request->nama_lengkap,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'pangkat_gol' => $request->pangkat_gol,
                'jabatan' => $request->jabatan,
                'status_pegawai' => $request->status_pegawai,
                'foto' => $fotoPath,
                'status_aktif' => 'Aktif',
            ]);

            DB::commit();
            return redirect()->route('operator.guru.index')->with('success', 'Data Guru berhasil ditambahkan! Akun login otomatis dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('operator.guru.edit', compact('guru'));
    }

    public function update(Request $request, string $id)
    {
        $guru = Guru::findOrFail($id);
        
        $request->validate([
            'nip' => 'nullable|string|max:20|unique:gurus,nip,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'pangkat_gol' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'status_pegawai' => 'nullable|string|max:50',
            'status_aktif' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto_guru', 'public');
        }
        $data['status_aktif'] = $request->status_aktif ? 'Aktif' : 'Tidak Aktif';
        $guru->update($data);

        if ($guru->user) {
            $guru->user->update([
                'is_active' => $request->status_aktif ? true : false
            ]);
        }

        return redirect()->route('operator.guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        DB::beginTransaction();

        try {
            $guru->update(['status_aktif' => 'Tidak Aktif']);

            if ($guru->user) {
                $guru->user->update(['is_active' => false]);
            }

            DB::commit();
            return redirect()->route('operator.guru.index')->with('success', 'Data guru dinonaktifkan dan akses login telah dicabut!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menonaktifkan data: ' . $e->getMessage());
        }
    }

    /**
     * Export Data berdasarkan pilihan: Guru Saja, Pimpinan Saja, atau Keduanya
     */
    public function exportPegawai(Request $request)
    {
        $type = $request->query('type', 'all');

        $prefix = 'Data_Semua_Pegawai_';
        if ($type === 'guru') $prefix = 'Data_Khusus_Guru_';
        if ($type === 'pimpinan') $prefix = 'Data_Khusus_Pimpinan_';
        
        $fileName = $prefix . date('Y-m-d') . '.xlsx';

        return Excel::download(new GuruExport($type), $fileName);
    }
}