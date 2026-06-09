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

// Tambahan Import Facade DomPDF dan Model
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Pimpinan;

class LaporanController extends Controller
{
    // ==========================================
    // 1. MANAJEMEN EKSPOR & IMPOR EXCEL GURU
    // ==========================================
    public function exportGuruExcel()
    {
        $data = Guru::all();
        return Excel::download(new GuruExport($data), 'Data_Guru_SMPN4Palu.xlsx');
    }

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

    // ==========================================
    // 2. MANAJEMEN EKSPOR & IMPOR EXCEL SISWA
    // ==========================================
    public function exportSiswaExcel()
    {
        $data = Siswa::all();
        return Excel::download(new SiswaExport($data), 'Data_Siswa_SMPN4Palu.xlsx');
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

    // ==========================================
    // 3. MANAJEMEN EKSPOR PDF GURU & SISWA
    // ==========================================

    public function exportGuruPDF()
    {
        $data = Guru::all()->map(function($guru) {
            $nip = $guru->nip;
            $guru->nip_format = (strlen($nip) === 18) ? substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 1) . ' ' . substr($nip, 15, 3) : $nip;
            return $guru;
        });

        $pdf = Pdf::loadView('laporan.guru_pdf', compact('data'))->setPaper('a4', 'portrait');
        return $pdf->download('Laporan_Data_Guru_SMPN4Palu.pdf');
    }

    public function exportSiswaPDF()
    {
        $data = Siswa::with('kelas')->get();
        $pdf = Pdf::loadView('laporan.siswa_pdf', compact('data'))->setPaper('a4', 'portrait');
        return $pdf->download('Laporan_Data_Siswa_SMPN4Palu.pdf');
    }

    // ==========================================
    // 4. MANAJEMEN EKSPOR PIMPINAN (EXCEL & PDF)
    // ==========================================

    public function exportPimpinanExcel()
    {
        $data = Pimpinan::all();
        return Excel::download(new PimpinanExport($data), 'Data_Pimpinan_SMPN4Palu.xlsx');
    }

    public function exportPimpinanPDF()
    {
        $data = Pimpinan::all()->map(function($pimpinan) {
            $nip = $pimpinan->nip;
            $pimpinan->nip_format = (strlen($nip) === 18) ? substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 1) . ' ' . substr($nip, 15, 3) : $nip;
            return $pimpinan;
        });

        $pdf = Pdf::loadView('laporan.pimpinan_pdf', compact('data'))->setPaper('a4', 'portrait');
        return $pdf->download('Laporan_Data_Pimpinan_SMPN4Palu.pdf');
    }
}
