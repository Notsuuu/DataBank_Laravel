<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class GuruController extends Controller
{
    /**
     * GET /api/guru
     * Menampilkan semua data guru
     */
    public function index()
    {
        // Mengambil semua guru beserta data akun user-nya (email, status)
        $gurus = Guru::with('user:id,email,is_active')->get();

        return response()->json([
            'status' => 'success',
            'data' => $gurus
        ]);
    }

    /**
     * POST /api/guru
     * Menambahkan data guru baru
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Data
        $validated = $request->validate([
            // user_id harus ada di tabel users, dan belum pernah dipakai di tabel gurus
            'user_id' => 'required|exists:users,id|unique:gurus,user_id',
            'nip' => 'nullable|string|max:25|unique:gurus,nip',
            'nama_lengkap' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:15',
            'gelar_belakang' => 'nullable|string|max:15',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        // 2. Simpan ke Database
        $guru = Guru::create($validated);

        // 3. Kembalikan Respons JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Data guru berhasil ditambahkan.',
            'data' => $guru
        ], 201); // 201 Created
    }

    // Fungsi show, update, dan destroy bisa dibiarkan kosong dulu untuk nanti

    /**
     * GET /api/guru/{id}
     * Menampilkan satu data guru spesifik
     */
    public function show(string $id)
    {
        $guru = Guru::with('user:id,email,is_active')->find($id);

        if (!$guru) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $guru
        ]);
    }

    /**
     * PUT/PATCH /api/guru/{id}
     * Memperbarui data guru
     */
    public function update(Request $request, string $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan.'
            ], 404);
        }

        // Validasi data baru (memakai "sometimes" agar tidak wajib diisi semua jika hanya update parsial)
        // Pengecualian ID pada validasi NIP agar tidak error "NIP sudah dipakai" oleh dirinya sendiri
        $validated = $request->validate([
            'nip' => 'nullable|string|max:25|unique:gurus,nip,' . $guru->id,
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'gelar_depan' => 'nullable|string|max:15',
            'gelar_belakang' => 'nullable|string|max:15',
            'jenis_kelamin' => 'sometimes|required|in:L,P',
            'tempat_lahir' => 'sometimes|required|string|max:50',
            'tanggal_lahir' => 'sometimes|required|date',
            'agama' => 'sometimes|required|string|max:20',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $guru->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data guru berhasil diperbarui.',
            'data' => $guru
        ]);
    }

    /**
     * DELETE /api/guru/{id}
     * Menghapus data guru
     */
    public function destroy(string $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan.'
            ], 404);
        }

        $guru->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data guru berhasil dihapus.'
        ]);
    }

    /**
     * POST /api/guru/{id}/foto
     * Mengunggah atau memperbarui foto profil guru
     */
    public function uploadFoto(Request $request, string $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json(['status' => 'error', 'message' => 'Data guru tidak ditemukan.'], 404);
        }

        // Validasi: harus berupa gambar (jpeg/png/jpg) dan maksimal 2MB
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika guru sudah punya foto sebelumnya, hapus foto lama dari folder storage
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        // Simpan foto baru ke folder 'storage/app/public/guru_fotos'
        $path = $request->file('foto')->store('guru_fotos', 'public');

        // Simpan path-nya ke database
        $guru->update(['foto' => $path]);

        return response()->json([
            'status' => 'success',
            'message' => 'Foto profil berhasil diunggah.',
            // asset() akan menghasilkan URL lengkap: http://127.0.0.1:8000/storage/guru_fotos/namafile.jpg
            'foto_url' => asset('storage/' . $path)
        ]);
    }
}
