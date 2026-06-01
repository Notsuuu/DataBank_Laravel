<?php

namespace App\Http\Controllers;

use App\Models\DataKepegawaian;
use Illuminate\Http\Request;

class DataKepegawaianController extends Controller
{
    public function index()
    {
        // Tampilkan semua data kepegawaian beserta nama gurunya
        $data = DataKepegawaian::with('guru:id,nama_lengkap')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:gurus,id|unique:data_kepegawaians,guru_id',
            'status_pegawai' => 'required|string|max:20',
            'nip' => 'nullable|string|max:25',
            'golongan' => 'nullable|string|max:10',
            'jabatan' => 'required|string|max:50',
            'sk_pengangkatan' => 'nullable|string'
        ]);

        $kepegawaian = DataKepegawaian::create($validated);
        return response()->json(['status' => 'success', 'data' => $kepegawaian], 201);
    }

    public function show(string $id)
    {
        $kepegawaian = DataKepegawaian::with('guru:id,nama_lengkap')->find($id);
        if (!$kepegawaian) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);

        return response()->json(['status' => 'success', 'data' => $kepegawaian]);
    }

    public function update(Request $request, string $id)
    {
        $kepegawaian = DataKepegawaian::find($id);
        if (!$kepegawaian) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);

        $validated = $request->validate([
            'guru_id' => 'sometimes|required|exists:gurus,id|unique:data_kepegawaians,guru_id,' . $kepegawaian->id,
            'status_pegawai' => 'sometimes|required|string|max:20',
            'nip' => 'nullable|string|max:25',
            'golongan' => 'nullable|string|max:10',
            'jabatan' => 'sometimes|required|string|max:50',
            'sk_pengangkatan' => 'nullable|string'
        ]);

        $kepegawaian->update($validated);
        return response()->json(['status' => 'success', 'data' => $kepegawaian]);
    }

    public function destroy(string $id)
    {
        $kepegawaian = DataKepegawaian::find($id);
        if (!$kepegawaian) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);

        $kepegawaian->delete();
        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
