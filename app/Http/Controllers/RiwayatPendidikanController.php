<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikan;
use Illuminate\Http\Request;

class RiwayatPendidikanController extends Controller
{
    public function index()
    {
        $data = RiwayatPendidikan::with('guru:id,nama_lengkap')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'jenjang' => 'required|string|max:10',
            'institusi' => 'required|string',
            'jurusan' => 'required|string',
            'tahun_lulus' => 'required|digits:4|integer'
        ]);

        $pendidikan = RiwayatPendidikan::create($validated);
        return response()->json(['status' => 'success', 'data' => $pendidikan], 201);
    }

    public function show(string $id)
    {
        $pendidikan = RiwayatPendidikan::with('guru:id,nama_lengkap')->find($id);
        if (!$pendidikan) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);

        return response()->json(['status' => 'success', 'data' => $pendidikan]);
    }

    public function update(Request $request, string $id)
    {
        $pendidikan = RiwayatPendidikan::find($id);
        if (!$pendidikan) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);

        $validated = $request->validate([
            'guru_id' => 'sometimes|required|exists:gurus,id',
            'jenjang' => 'sometimes|required|string|max:10',
            'institusi' => 'sometimes|required|string',
            'jurusan' => 'sometimes|required|string',
            'tahun_lulus' => 'sometimes|required|digits:4|integer'
        ]);

        $pendidikan->update($validated);
        return response()->json(['status' => 'success', 'data' => $pendidikan]);
    }

    public function destroy(string $id)
    {
        $pendidikan = RiwayatPendidikan::find($id);
        if (!$pendidikan) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);

        $pendidikan->delete();
        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
