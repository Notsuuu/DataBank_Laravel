<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::latest()->get();
        return view('operator.siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('operator.siswa.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:siswas,nisn',
            'nis' => 'nullable|string|max:20|unique:siswas,nis',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Proses Upload Foto (jika ada)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswa_fotos', 'public');
        }

        // 3. Simpan Menggunakan DB Transaction
        DB::transaction(function () use ($request, $fotoPath) {
            // A. Buat Akun User Siswa
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa', // Pastikan enum role di DB mendukung 'siswa'
                'is_active' => true,
            ]);

            // B. Buat Profil Siswa
            Siswa::create([
                'user_id' => $user->id,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'foto' => $fotoPath,
            ]);
        });

        // 4. Kembali ke halaman tabel
        return redirect()->route('operator.siswa.index')->with('success', 'Data Siswa, Foto, dan Akun berhasil ditambahkan!');
    }
}
