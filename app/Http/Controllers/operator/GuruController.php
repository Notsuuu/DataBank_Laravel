<?php

namespace App\Http\Controllers\operator; 

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource (M5: F-08 Pencarian & Filter)
     */
    public function index(Request $request)
    {
        // 1. Ambil semua parameter filter dari URL
        $keyword = $request->input('q');          // Untuk pencarian Nama / NIP / NUPTK
        $status = $request->input('status');      // Untuk filter status_aktif
        $tingkatKelas = $request->input('kelas'); // Untuk filter tingkat kelas (misal: 7, 8, 9)

        // 2. Buat query dasar
        $query = Guru::query();

        // 3. Eksekusi Pencarian Ganda (Nama, NIP, atau NUPTK)
        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('nama_lengkap', 'LIKE', "%{$keyword}%")
                  ->orWhere('nip', 'LIKE', "%{$keyword}%")
                  ->orWhere('nuptk', 'LIKE', "%{$keyword}%");
            });
        }

        // 4. Eksekusi Filter Status Aktif
        if (!empty($status)) {
            $query->where('status_aktif', $status);
        }

        // 5. Eksekusi Filter Wali Kelas
        if (!empty($tingkatKelas)) {
            $query->whereHas('kelas', function($q) use ($tingkatKelas) {
                $q->where('tingkat', $tingkatKelas); 
            });
        }

        // 6. Tarik data dari database
        $para_guru = $query->get();

        // 7. Kirim data dan parameter ke halaman View
        return view('operator.index_guru', compact('para_guru', 'keyword', 'status', 'tingkatKelas'));
    }
}