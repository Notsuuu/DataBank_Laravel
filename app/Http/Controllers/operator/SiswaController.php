<?php

namespace App\Http\Controllers\operator;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('q');
        $kelasFilter = $request->input('kelas');
        
        $semuaKelas = \App\Models\Kelas::all(); // Ambil semua kelas untuk dropdown
        $query = \App\Models\Siswa::query();

        if ($keyword) {
            // Bungkus dalam fungsi agar menjadi: (nama LIKE ... OR nisn LIKE ...)
                $query->where(function($q) use ($keyword) {
                $q->where('nama_lengkap', 'LIKE', "%$keyword%")
                  ->orWhere('nisn', 'LIKE', "%$keyword%");
            });
        }
        
        if ($kelasFilter) {
            $query->where('kelas_id', $kelasFilter);
        }

        $para_siswa = $query->paginate(10);
        return view('operator.index_siswa', compact('para_siswa', 'keyword', 'kelasFilter', 'semuaKelas'));
    }
}
