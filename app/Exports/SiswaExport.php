<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    public function collection()
    {
        return Siswa::all();
    }

    public function headings(): array
    {
        return [
            'NIS', 
            'NISN', 
            'Nama Lengkap', 
            'L/P', 
            'Tempat Lahir', 
            'Tanggal Lahir', 
            'Agama', 
            'Alamat', 
            'Nama Wali', 
            'No HP Wali'
        ];
    }

    public function map(mixed $siswa): array
    {
        return [
            $siswa->nis,
            $siswa->nisn,
            $siswa->nama_lengkap,
            $siswa->jenis_kelamin,
            $siswa->tempat_lahir,
            $siswa->tanggal_lahir,
            $siswa->agama,
            $siswa->alamat,
            $siswa->nama_wali,
            $siswa->no_hp_wali ?? '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, 
            'B' => NumberFormat::FORMAT_TEXT, 
            'J' => NumberFormat::FORMAT_TEXT, 
        ];
    }
}