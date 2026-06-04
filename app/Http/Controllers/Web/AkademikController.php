<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Rombel;
use Illuminate\Http\Request;

class AkademikController extends Controller
{
    public function tahunAjaran()
    {
        $tahunAjarans = TahunAjaran::latest()->get();
        return view('operator.akademik.tahun-ajaran', compact('tahunAjarans'));
    }

    public function kelas()
    {
        $kelas = Kelas::with('waliKelas')->latest()->get();
        return view('operator.akademik.kelas', compact('kelas'));
    }

    public function mapel()
    {
        $mapels = Mapel::latest()->get();
        return view('operator.akademik.mapel', compact('mapels'));
    }

    public function rombel()
    {
        $rombels = Rombel::with(['siswa', 'kelas', 'tahunAjaran'])->latest()->get();
        return view('operator.akademik.rombel', compact('rombels'));
    }
}
