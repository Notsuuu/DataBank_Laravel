<?php

namespace App\Exports;

use App\Models\Pimpinan; // Pastikan ini mengarah ke model Pimpinan yang baru
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PimpinanExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    public function collection()
    {
        // Mengambil langsung dari tabel pimpinans
        return Pimpinan::all();
    }

    public function headings(): array
    {
        return ['NIP', 'Nama Lengkap', 'L/P', 'Nomor HP', 'Status Jabatan'];
    }

    public function map($pimpinan): array
    {
        $nip = $pimpinan->nip;

        // Format NIP menjadi standar BKN (8-6-1-3)
        if (strlen($nip) === 18) {
            $nipResmi = substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 1) . ' ' . substr($nip, 15, 3);
        } else {
            $nipResmi = ' ' . $nip;
        }

        return [
            $nipResmi,
            $pimpinan->gelar_depan . ' ' . $pimpinan->nama_lengkap . ' ' . $pimpinan->gelar_belakang,
            $pimpinan->jenis_kelamin,
            $pimpinan->no_hp,
            $pimpinan->status_aktif,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Memastikan NIP tidak terpotong oleh Excel
        ];
    }
}
