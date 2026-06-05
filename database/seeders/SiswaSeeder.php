<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaSeeder extends Seeder {
    public function run(): void {
        $semuaKelas = Kelas::all();
        for ($i = 1; $i <= 20; $i++) {
            Siswa::create([
                'nisn'          => '1000' . $i,
                'nis'           => '2026' . $i,
                'nama_lengkap'  => 'Siswa Contoh ' . $i,
                'jenis_kelamin' => ($i % 2 == 0) ? 'L' : 'P',
                'tempat_lahir'  => 'Palu',
                'tanggal_lahir' => '2012-01-01',
                'agama'         => 'Islam',
                'kelas_id'      => $semuaKelas->isNotEmpty() ? $semuaKelas->random()->id : null
            ]);
        }
    }
}