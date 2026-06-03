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
            ['nama_kelas' => 'VII A', 'tingkat' => '7'],
            ['nama_kelas' => 'VII B', 'tingkat' => '7'],
            ['nama_kelas' => 'VIII A', 'tingkat' => '8'],
            ['nama_kelas' => 'IX A', 'tingkat' => '9'],
        ];

        foreach ($data as $index => $k) {
            Kelas::create([
                'nama_kelas' => $k['nama_kelas'], 
                'tingkat' => $k['tingkat'], 
                // Gunakan modulo agar ID wali kelas berputar di antara guru yang ada
                'wali_kelas_id' => $guruIds[$index % count($guruIds)]
            ]);
        }
    }
}