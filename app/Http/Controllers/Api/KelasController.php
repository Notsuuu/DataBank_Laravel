<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        // Panggil kelas sekalian dengan data wali kelasnya (nama_lengkap)
        $kelas = Kelas::with('waliKelas:id,nama_lengkap')->get();
        return response()->json(['status' => 'success', 'data' => $kelas]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas',
            'tingkat' => 'required|in:VII,VIII,IX',
            'wali_kelas_id' => 'nullable|exists:gurus,id'
        ]);

        $kelas = Kelas::create($validated);
        return response()->json(['status' => 'success', 'data' => $kelas], 201);
    }
}
