<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * GET /api/siswa
     * Menampilkan semua data siswa
     */
    public function index()
    {
        $siswas = Siswa::all();
        return response()->json([
            'status' => 'success',
            'data' => $siswas
        ]);
    }

    /**
     * POST /api/siswa
     * Menambahkan data siswa baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:siswas,nis',
            'nisn' => 'nullable|string|max:20|unique:siswas,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'nama_wali' => 'nullable|string|max:255',
            'no_hp_wali' => 'nullable|string|max:15',
        ]);

        $siswa = Siswa::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data siswa berhasil ditambahkan.',
            'data' => $siswa
        ], 201);
    }

    /**
     * GET /api/siswa/{id}
     * Menampilkan satu data siswa spesifik
     */
    public function show(string $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $siswa
        ]);
    }

    /**
     * PUT/PATCH /api/siswa/{id}
     * Memperbarui data siswa
     */
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        // Pengecualian ID pada validasi unique agar NIS/NISN tidak bentrok dengan miliknya sendiri
        $validated = $request->validate([
            'nis' => 'sometimes|required|string|max:20|unique:siswas,nis,' . $siswa->id,
            'nisn' => 'nullable|string|max:20|unique:siswas,nisn,' . $siswa->id,
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'jenis_kelamin' => 'sometimes|required|in:L,P',
            'tempat_lahir' => 'sometimes|required|string|max:50',
            'tanggal_lahir' => 'sometimes|required|date',
            'agama' => 'sometimes|required|string|max:20',
            'alamat' => 'nullable|string',
            'nama_wali' => 'nullable|string|max:255',
            'no_hp_wali' => 'nullable|string|max:15',
        ]);

        $siswa->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data siswa berhasil diperbarui.',
            'data' => $siswa
        ]);
    }

    /**
     * DELETE /api/siswa/{id}
     * Menghapus data siswa
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        $siswa->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data siswa berhasil dihapus.'
        ]);
    }
}
