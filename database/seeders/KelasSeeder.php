<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Guru;

class KelasSeeder extends Seeder {
    public function run(): void {
        // Ambil semua ID Guru yang ada di database
        $guruIds = Guru::pluck('id')->toArray();

        $data = [
            ['tingkat' => 'VII', 'nama' => 'VII-A'],
            ['tingkat' => 'VII', 'nama' => 'VII-B'],
            ['tingkat' => 'VIII', 'nama' => 'VIII-A'],
            ['tingkat' => 'IX', 'nama' => 'IX-A'],
        ];

        foreach ($data as $index => $k) {
            Kelas::create([
                'tingkat_kelas' => $k['tingkat'],
                'nama_kelas'    => $k['nama'],
                // Gunakan 'guru_id' sesuai migrasi temanmu
                'guru_id'       => !empty($guruIds) ? $guruIds[$index % count($guruIds)] : null
            ]);
        }
    }
}