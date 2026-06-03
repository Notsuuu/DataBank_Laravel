<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\User;

class GuruSeeder extends Seeder {
    public function run(): void {
        $guruList = [
            ['email' => 'diyo@smpn4palu.sch.id', 'nip' => '1001', 'jk' => 'L', 'lahir' => 'Palu'],
            ['email' => 'hafizh@smpn4palu.sch.id', 'nip' => '1002', 'jk' => 'L', 'lahir' => 'Donggala'],
            ['email' => 'sofia@smpn4palu.sch.id', 'nip' => '1003', 'jk' => 'P', 'lahir' => 'Poso'],
        ];
        
        foreach ($guruList as $g) {
            $user = User::where('email', $g['email'])->first();
            Guru::create([
                'user_id' => $user->id,
                'nama_lengkap' => $user->name,
                'nip' => $g['nip'],
                'status_aktif' => 'Aktif',
                'jenis_kelamin' => $g['jk'],
                'tempat_lahir' => $g['lahir'],
                'tanggal_lahir' => '1990-01-01',
                'agama' => 'Islam',
                'alamat' => 'Jl. Pendidikan No. 1, Palu'
            ]);
        }
    }
}