<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuruExport;
use App\Exports\PimpinanExport;
use App\Imports\GuruImport;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Illuminate\Database\QueryException;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Pimpinan;

class LaporanController extends Controller
{
    public function importGuru(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls,csv|max:5120']);
        try {
            Excel::import(new GuruImport, $request->file('file_excel'));
            return back()->with('success', 'Data guru berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor: ' . $e->getMessage());
        }
    }

    public function importSiswa(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls,csv|max:5120']);
        try {
            Excel::import(new SiswaImport, $request->file('file_excel'));
            return back()->with('success', 'Data siswa berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor: ' . $e->getMessage());
        }
    }

    public function exportGuruPDF(Request $request)
    {
        $type = trim($request->query('type', 'all'));
        $data = collect();

        if ($type === 'all' || $type === 'pimpinan') {
            $pimpinans = Pimpinan::with('user')->where('status_aktif', 'Aktif')->get();
            foreach ($pimpinans as $p) {
                $p->jabatan = $p->jabatan ?? 'Kepala Sekolah';
                $data->push($p);
            }
        }

        if ($type === 'all' || $type === 'guru') {
            $gurus = Guru::with('user')
                ->where('status_aktif', 'Aktif')
                ->whereHas('user', function ($q) {
                    $q->where('role', 'guru');
                })
                ->get();
            foreach ($gurus as $g) {
                $g->jabatan = $g->jabatan ?? 'Guru';
                $data->push($g);
            }
        }

        $data = $data->map(function($pegawai) {
            $nip = $pegawai->nip;
            $pegawai->nip_format = (strlen((string)$nip) === 18) 
                ? substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 1) . ' ' . substr($nip, 15, 3) 
                : ($nip ? $nip : '-');
            
            $pegawai->nama_final = trim($pegawai->gelar_depan . ' ' . $pegawai->nama_lengkap . ' ' . $pegawai->gelar_belakang);
            
            return $pegawai;
        });

        $prefix = 'Laporan_Pegawai_Aktif_';
        $judulLaporan = 'Laporan Data Pegawai (Guru & Pimpinan) Aktif';
        
        if ($type === 'guru') {
            $prefix = 'Laporan_Guru_Aktif_';
            $judulLaporan = 'Laporan Data Guru Aktif';
        } elseif ($type === 'pimpinan') {
            $prefix = 'Laporan_Pimpinan_Aktif_';
            $judulLaporan = 'Laporan Data Pimpinan Aktif';
        }

        $fileName = $prefix . date('Y-m-d') . '.pdf';

        $pdf = Pdf::loadView('laporan.guru_pdf', compact('data', 'judulLaporan'))->setPaper('a4', 'portrait');
        return $pdf->download($fileName);
    }

    public function exportSiswaPDF()
    {
        $data = Siswa::with('kelas')->get();
        $pdf = Pdf::loadView('laporan.siswa_pdf', compact('data'))->setPaper('a4', 'portrait');
        return $pdf->download('Laporan_Data_Siswa_SMPN4Palu.pdf');
    }

    public function exportPimpinanPDF()
    {
        $data = Pimpinan::orderBy('status_aktif', 'asc')->latest()->get()->map(function($pimpinan) {
            $nip = $pimpinan->nip;  
            $pimpinan->nip_format = (strlen((string)$nip) === 18) 
                ? substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 1) . ' ' . substr($nip, 15, 3) 
                : ($nip ? $nip : '-');
            return $pimpinan;
        });

        $pdf = Pdf::loadView('laporan.pimpinan_pdf', compact('data'))->setPaper('a4', 'portrait');
        return $pdf->download('Laporan_Data_Pimpinan_SMPN4Palu.pdf');
    }

    public function exportSiswaExcel()
    {
        return Excel::download(new SiswaExport(), 'Data_Siswa_SMPN4Palu.xlsx');
    }

    public function exportPimpinanExcel()
    {
        return Excel::download(new PimpinanExport(), 'Data_Pimpinan_SMPN4Palu.xlsx');
    }
}