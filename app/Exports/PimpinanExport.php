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
        return ['NIP', 'Nama Lengkap', 'L/P', 'Nomor HP', 'Status Jabatan'];
    }

    public function map($pimpinan): array
    {
        $nip = $pimpinan->nip;

        if (strlen($nip) === 18) {
            $nipResmi = substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 1) . ' ' . substr($nip, 15, 3);
        } else {
            $nipResmi = $nip ? ' ' . $nip : '-';
        }

        $namaFinal = trim($pimpinan->gelar_depan . ' ' . $pimpinan->nama_lengkap . ' ' . $pimpinan->gelar_belakang);

        return [
            $nipResmi,
            $namaFinal,
            $pimpinan->jenis_kelamin,
            $pimpinan->no_hp ?? '-',
            $pimpinan->status_aktif,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }
}