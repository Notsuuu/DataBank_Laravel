<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_lengkap', 'LIKE', "%{$keyword}%")->orWhere('nip', 'LIKE', "%{$keyword}%");
            });
        }

        if ($status) {
            $query->where('status_aktif', $status);
        }

        // Filter Kelas (Menggunakan nama 'tingkat_kelas' sesuai database)
        if ($tingkatKelas) {
            $query->whereHas('kelas', function ($q) use ($tingkatKelas) {
                $q->where('tingkat_kelas', $tingkatKelas);
            });
        }

        // Variabel dikirim sebagai 'para_guru' agar sesuai dengan file blade kamu
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Tentukan password default: NIP, atau 'guru123' jika NIP kosong (honorer)
            $defaultPassword = $request->nip ? $request->nip : 'guru123';

            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($defaultPassword),
                'role' => 'guru',
                'is_active' => true,
                'force_change_password' => true, // Menjebak guru agar wajib ganti sandi saat login
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
                'foto' => $fotoPath,
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

    // PERBAIKAN: Menambahkan tipe data 'string' pada $id
    public function edit(string $id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('operator.guru.edit', compact('guru'));
    }

    // PERBAIKAN: Menambahkan tipe data 'string' pada $id
    public function update(Request $request, string $id)
    {
        $guru = Guru::findOrFail($id);
        $request->validate([
            'nip' => 'required|string|max:20|unique:gurus,nip,' . $id,
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
            'no_hp' => 'required|string|max:15',
        ]);
        $guru->update($request->all());
        return redirect()->route('operator.guru.index')->with('success', 'Data Guru diperbarui!');
    }

    // PERBAIKAN: Menambahkan tipe data 'string' pada $id
    public function destroy(string $id)
    {
        // PERBAIKAN: Mengganti \App\Models\Guru menjadi Guru karena sudah di-import di atas
        $guru = Guru::findOrFail($id);

        // Hapus data (Observer di latar belakang akan otomatis mencatat 1 log DELETE dengan aman)
        $guru->delete();

        return redirect()->route('operator.guru.index')->with('success', 'Data guru berhasil dihapus dari sistem!');
    }
}