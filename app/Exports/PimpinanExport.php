<?php

namespace App\Exports;

use App\Models\Pimpinan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PimpinanExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    public function collection()
    {
        return Pimpinan::orderBy('status_aktif', 'asc')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'NIP', 
            'Nama Lengkap', 
            'Pangkat / Gol', 
            'Jabatan', 
            'Status Pegawai', 
            'L/P', 
            'Tempat Lahir', 
            'Tanggal Lahir', 
            'Agama', 
            'Nomor HP', 
            'Alamat', 
            'Status Akun'
        ];
    }

    public function map(mixed $pimpinan): array
    {
        $nip = $pimpinan->nip;

        // Format NIP agar ada spasinya jika panjangnya pas 18 karakter
        if (strlen((string)$nip) === 18) {
            $nipResmi = substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 1) . ' ' . substr($nip, 15, 3);
        } else {
            // Tambahkan spasi di depan agar Excel tidak mengubah angka 0 di depan menjadi hilang
            $nipResmi = $nip ? ' ' . $nip : '-';
        }

        $namaFinal = trim($pimpinan->gelar_depan . ' ' . $pimpinan->nama_lengkap . ' ' . $pimpinan->gelar_belakang);

        return [
            $nipResmi,
            $namaFinal,
            $pimpinan->pangkat_gol ?? '-',
            $pimpinan->jabatan ?? '-',
            $pimpinan->status_pegawai ?? '-',
            $pimpinan->jenis_kelamin ?? '-',
            $pimpinan->tempat_lahir ?? '-',
            $pimpinan->tanggal_lahir ?? '-',
            $pimpinan->agama ?? '-',
            $pimpinan->no_hp ?? '-',
            $pimpinan->alamat ?? '-',
            $pimpinan->status_aktif,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, 
            'J' => NumberFormat::FORMAT_TEXT, 
        ];
    }
}