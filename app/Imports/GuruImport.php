<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = User::create([
            'name' => $row['nama_lengkap'],
            'email' => $row['email'],
            'password' => Hash::make($row['nip']),
            'role' => 'guru',
            'is_active' => true,
            'force_change_password' => true,
        ]);

        return new Guru([
            'user_id' => $user->id,
            'nip' => $row['nip'],
            'nama_lengkap' => $row['nama_lengkap'],
            'gelar_depan' => $row['gelar_depan'] ?? null,
            'gelar_belakang' => $row['gelar_belakang'] ?? null,
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => is_numeric($row['tanggal_lahir']) 
                ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d') 
                : $row['tanggal_lahir'],
            'agama' => $row['agama'],
            'no_hp' => $row['no_hp'] ?? null,
            'alamat' => $row['alamat'] ?? null,
        ]);
    }
}