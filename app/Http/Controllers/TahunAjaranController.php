<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => TahunAjaran::all()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:9',
            'semester' => 'required|in:Ganjil,Genap',
            'is_active' => 'boolean'
        ]);

        // Jika diset aktif, matikan dulu tahun ajaran lain agar tidak ada 2 yang aktif
        if (isset($validated['is_active']) && $validated['is_active']) {
            TahunAjaran::where('is_active', true)->update(['is_active' => false]);
        }

        $tahunAjaran = TahunAjaran::create($validated);
        return response()->json(['status' => 'success', 'data' => $tahunAjaran], 201);
    }
}
