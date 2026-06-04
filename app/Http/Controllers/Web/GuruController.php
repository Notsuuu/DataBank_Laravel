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
     * Menampilkan halaman Daftar Guru (Untuk Operator)
     */
    public function index()
    {
        // Ambil data guru beserta relasi akun User-nya, urutkan dari yang terbaru
        $gurus = Guru::with('user')->latest()->get();
        return view('operator.guru.index', compact('gurus'));
    }

    /**
     * Menampilkan halaman Form Tambah Guru Baru
     */
    public function create()
    {
        return view('operator.guru.create');
    }

    /**
     * Memproses penyimpanan data ganda (User & Guru) menggunakan Transaction
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (disesuaikan dengan form baru)
        $request->validate([
            // Akun
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8',
            // Profil
            'nip'            => 'nullable|unique:gurus,nip', // Ubah jadi nullable karena ada opsi honorer
            'nama_lengkap'   => 'required|string|max:255',
            'gelar_depan'    => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'agama'          => 'required|string|max:50',
            'alamat'         => 'required|string',
            'no_hp'          => 'nullable|string|max:20',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Mulai Garansi Transaksi Database
        DB::beginTransaction();

        try {
            // A. Buat Akun Login
            $user = User::create([
                'name'      => $request->nama_lengkap,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => 'guru',
                'is_active' => true,
            ]);

            // B. Proses Upload Foto (Jika ada)
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto_guru', 'public');
            }

            // C. Buat Profil Fisik di tabel gurus (Field harus sama persis dengan yang ada di Migration)
            Guru::create([
                'user_id'        => $user->id,
                'nip'            => $request->nip,
                'nama_lengkap'   => $request->nama_lengkap,
                'gelar_depan'    => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'agama'          => $request->agama,
                'alamat'         => $request->alamat,
                'no_hp'          => $request->no_hp,
                'foto'           => $fotoPath,
            ]);

            DB::commit();

            return redirect()->route('operator.guru.index')
                             ->with('success', 'Data Guru dan Akun Login berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('operator.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $request->validate([
            'nip'           => 'required|string|max:20|unique:gurus,nip,' . $id,
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required|string|max:20',
            'no_hp'         => 'required|string|max:15',
        ]);
        $guru->update($request->all());
        return redirect()->route('operator.guru.index')->with('success', 'Data Guru diperbarui!');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        if($guru->user) {
            $guru->user->delete(); // Ini otomatis menghapus guru juga berkat relasi cascade
        } else {
            $guru->delete();
        }
        return back()->with('success', 'Data Guru dan Akunnya dihapus!');
    }
}
