<?php
namespace App\Http\Controllers;
use App\Models\Rombel;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    public function index() {
        $rombel = Rombel::with(['siswa:id,nama_lengkap', 'kelas:id,nama_kelas', 'tahunAjaran:id,tahun'])->get();
        return response()->json(['status' => 'success', 'data' => $rombel]);
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id'
        ]);
        $exists = Rombel::where('siswa_id', $validated['siswa_id'])
                        ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
                        ->first();
        if ($exists) {
            return response()->json(['status' => 'error', 'message' => 'Siswa sudah di kelas lain.'], 422);
        }
        $rombel = Rombel::create($validated);
        return response()->json(['status' => 'success', 'data' => $rombel], 201);
    }
    public function destroy(string $id) {
        $rombel = Rombel::find($id);
        if (!$rombel) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        $rombel->delete();
        return response()->json(['status' => 'success', 'message' => 'Siswa dikeluarkan dari kelas.']);
    }
}
