<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GuruExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Guru::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'NIP', 
            'Gelar Depan', 
            'Nama Lengkap', 
            'Gelar Belakang', 
            'Email', 
            'L/P', 
            'Tempat Lahir', 
            'Tanggal Lahir', 
            'Agama', 
            'No HP', 
            'Alamat'
        ];
    }

    public function map($guru): array
    {
        return [
            $guru->nip,
            $guru->gelar_depan,
            $guru->nama_lengkap,
            $guru->gelar_belakang,
            $guru->user->email ?? '-',
            $guru->jenis_kelamin,
            $guru->tempat_lahir,
            $guru->tanggal_lahir,
            $guru->agama,
            $guru->no_hp,
            $guru->alamat,
        ];
    }
}