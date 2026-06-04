<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::latest()->get();
        return view('operator.guru.index', compact('gurus'));
    }

    // Menampilkan halaman form tambah guru
    public function create()
    {
        return view('operator.guru.create');
    }

    // Memproses data dari form
    public function store(Request $request)
    {
        // 1. Validasi Input (Tambahkan validasi foto)
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'nullable|string|max:25|unique:gurus,nip',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        // 2. Proses Upload Foto (jika ada)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Simpan ke folder 'storage/app/public/guru_fotos'
            $fotoPath = $request->file('foto')->store('guru_fotos', 'public');
        }

        // 3. Simpan Data Menggunakan Transaksi Database
        DB::transaction(function () use ($request, $fotoPath) {
            // A. Buat Akun User Dulu
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru',
                'is_active' => true,
            ]);

            // B. Buat Profil Guru yang Terhubung ke User ID
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
                'no_hp' => $request->no_hp,
                'foto' => $fotoPath, // Simpan path foto ke database
            ]);
        });

        // 4. Kembalikan ke halaman tabel dengan pesan sukses
        return redirect()->route('operator.guru.index')->with('success', 'Data Guru, Foto, dan Akun berhasil ditambahkan!');
    }
}
