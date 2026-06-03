<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaSeeder extends Seeder {
    public function run(): void {
        $semuaKelas = Kelas::all();
        
        // Loop untuk membuat 20 siswa dummy
        for ($i = 1; $i <= 20; $i++) {
            Siswa::create([
                'nisn' => '1000' . $i,
                'nis' => '2026' . $i,
                'nama_lengkap' => 'Siswa Contoh ' . $i,
                'jenis_kelamin' => ($i % 2 == 0) ? 'L' : 'P',
                'kelas_id' => $semuaKelas->random()->id // Ambil kelas acak
            ]);
        }
    }
}