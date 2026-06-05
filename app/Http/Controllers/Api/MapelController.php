<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index() {
        return response()->json(['status' => 'success', 'data' => Mapel::all()]);
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:20|unique:mapels,kode_mapel',
            'nama_mapel' => 'required|string|max:255',
            'kelompok' => 'required|in:A,B,C'
        ]);
        $mapel = Mapel::create($validated);
        return response()->json(['status' => 'success', 'data' => $mapel], 201);
    }
    public function show(string $id) {
        $mapel = Mapel::find($id);
        if (!$mapel) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        return response()->json(['status' => 'success', 'data' => $mapel]);
    }
    public function update(Request $request, string $id) {
        $mapel = Mapel::find($id);
        if (!$mapel) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        $validated = $request->validate([
            'kode_mapel' => 'sometimes|required|string|max:20|unique:mapels,kode_mapel,' . $mapel->id,
            'nama_mapel' => 'sometimes|required|string|max:255',
            'kelompok' => 'sometimes|required|in:A,B,C'
        ]);
        $mapel->update($validated);
        return response()->json(['status' => 'success', 'data' => $mapel]);
    }
    public function destroy(string $id) {
        $mapel = Mapel::find($id);
        if (!$mapel) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        $mapel->delete();
        return response()->json(['status' => 'success', 'message' => 'Data dihapus']);
    }
}
