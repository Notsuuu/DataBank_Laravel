<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Siswa([
            'nis'           => $row['nis'],
            'nisn'          => $row['nisn'] ?? null,
            'nama_lengkap'  => $row['nama_lengkap'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tempat_lahir'  => $row['tempat_lahir'],
            'tanggal_lahir' => is_numeric($row['tanggal_lahir']) 
                ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d') 
                : $row['tanggal_lahir'],
            'agama'         => $row['agama'],
            'alamat'        => $row['alamat'] ?? null,
            'nama_wali'     => $row['nama_wali'] ?? null,
            'no_hp_wali'    => $row['no_hp_wali'] ?? null,
        ]);
    }
}