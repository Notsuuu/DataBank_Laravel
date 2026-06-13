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
        return Siswa::with('kelas')->orderBy('nama_lengkap', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'NIS', 
            'NISN', 
            'NIK',
            'Nama Lengkap', 
            'Kelas',
            'L/P', 
            'Tempat Lahir', 
            'Tanggal Lahir', 
            'Agama', 
            'Alamat',
            'RT',
            'RW',
            'Kelurahan',
            'Kecamatan',
            'Kode Pos',
            'No HP Siswa',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'Nama Wali', 
            'No HP Wali'
        ];
    }

    public function map(mixed $siswa): array
    {
        return [
            $siswa->nis ?? '-',
            $siswa->nisn ?? '-',
            $siswa->nik ?? '-',
            $siswa->nama_lengkap,
            $siswa->kelas->nama_kelas ?? 'Belum Ada Kelas',
            $siswa->jenis_kelamin ?? '-',
            $siswa->tempat_lahir ?? '-',
            $siswa->tanggal_lahir ?? '-',
            $siswa->agama ?? '-',
            $siswa->alamat ?? '-',
            $siswa->rt ?? '-',
            $siswa->rw ?? '-',
            $siswa->kelurahan ?? '-',
            $siswa->kecamatan ?? '-',
            $siswa->kode_pos ?? '-',
            $siswa->no_hp_siswa ?? '-',
            $siswa->nama_ayah ?? '-',
            $siswa->pekerjaan_ayah ?? '-',
            $siswa->nama_ibu ?? '-',
            $siswa->pekerjaan_ibu ?? '-',
            $siswa->nama_wali ?? '-',
            $siswa->no_hp_wali ?? '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, 
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT, 
            'O' => NumberFormat::FORMAT_TEXT, 
            'P' => NumberFormat::FORMAT_TEXT, 
            'V' => NumberFormat::FORMAT_TEXT, 
        ];
    }
}