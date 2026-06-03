<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user (sebagai dummy user_id)
        // Kita asumsikan user_id 1 sudah ada (bisa buat seeder UserSeeder dulu jika belum)
        
        Guru::insert([
            [
                'user_id' => 1,
                'nip' => '198001012000011001',
                'nuptk' => '1234567890123456',
                'nama_lengkap' => 'Ahmad Rifaldi',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Palu',
                'tanggal_lahir' => '1980-01-01',
                'agama' => 'Islam',
                'status_aktif' => 'Aktif',
                'created_at' => now(),
            ],
            [
                'user_id' => 1,
                'nip' => '198502022005012002',
                'nuptk' => '9876543210987654',
                'nama_lengkap' => 'Siti Aminah',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Donggala',
                'tanggal_lahir' => '1985-02-02',
                'agama' => 'Islam',
                'status_aktif' => 'Tidak Aktif',
                'created_at' => now(),
            ]
        ]);
    }
}