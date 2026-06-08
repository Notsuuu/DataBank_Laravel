<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuruExport;
use App\Imports\GuruImport;

class LaporanController extends Controller
{
    public function exportGuruExcel()
    {
        return Excel::download(new GuruExport, 'Data_Guru_SMPN4Palu.xlsx');
    }

    public function importGuru(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file_excel.required' => 'Pilih file terlebih dahulu.',
            'file_excel.mimes' => 'Format file harus berupa .xlsx, .xls, atau .csv.',
            'file_excel.max' => 'Ukuran file tidak boleh lebih dari 5MB.'
        ]);

        try {
            Excel::import(new GuruImport, $request->file('file_excel'));
            
            return back()->with('success', 'Data guru berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data. Error: ' . $e->getMessage());
        }
    }
}