<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\DataKepegawaian;
use App\Models\RiwayatPendidikan;
use App\Models\Pimpinan;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $passwordStandar = Hash::make('password123');

        DB::beginTransaction();
        try {
            // ==========================================
            // 1. SEEDER TAHUN AJARAN & MAPEL
            // ==========================================
            $taGanjil = TahunAjaran::create(['tahun' => '2025/2026', 'semester' => 'Ganjil', 'is_active' => 0]);
            $taGenap  = TahunAjaran::create(['tahun' => '2025/2026', 'semester' => 'Genap', 'is_active' => 1]);

            $daftarMapel = [
                ['kode_mapel' => 'MPL01', 'nama_mapel' => 'Pendidikan Agama Islam', 'kelompok_mapel' => 'A (Wajib)'],
                ['kode_mapel' => 'MPL02', 'nama_mapel' => 'Pendidikan Pancasila', 'kelompok_mapel' => 'A (Wajib)'],
                ['kode_mapel' => 'MPL03', 'nama_mapel' => 'Bahasa Indonesia', 'kelompok_mapel' => 'A (Wajib)'],
                ['kode_mapel' => 'MPL04', 'nama_mapel' => 'Matematika', 'kelompok_mapel' => 'A (Wajib)'],
                ['kode_mapel' => 'MPL05', 'nama_mapel' => 'Ilmu Pengetahuan Alam', 'kelompok_mapel' => 'A (Wajib)'],
                ['kode_mapel' => 'MPL06', 'nama_mapel' => 'Prakarya / Informatika', 'kelompok_mapel' => 'B (Muatan Lokal)'],
            ];
            foreach ($daftarMapel as $m) {
                Mapel::create($m);
            }

            // ==========================================
            // 2. SEEDER PENGGUNA INTI (Admin & Pimpinan)
            // ==========================================
            User::create(['name' => 'Muhammad Ali Mubaraq', 'email' => 'operator1@smpn4.com', 'password' => $passwordStandar, 'role' => 'operator', 'is_active' => 1]);
            User::create(['name' => 'Operator Utama 2', 'email' => 'operator2@smpn4.com', 'password' => $passwordStandar, 'role' => 'operator', 'is_active' => 1]);

            // Seeder Pimpinan dengan Tabel Terpisah (DITAMBAHKAN no_hp)
            for ($i = 1; $i <= 5; $i++) {
                $userPimpinan = User::create([
                    'name' => 'Pimpinan ' . $i,
                    'email' => 'pimpinan' . $i . '@smpn4.com',
                    'password' => $passwordStandar,
                    'role' => 'pimpinan',
                    'is_active' => 1
                ]);

                Pimpinan::create([
                    'user_id' => $userPimpinan->id,
                    'nama_lengkap' => $userPimpinan->name,
                    'nip' => $faker->unique()->numerify('198#########'),
                    'jenis_kelamin' => 'L',
                    'agama' => 'Islam',
                    'tempat_lahir' => 'Palu',
                    'tanggal_lahir' => '1985-05-20',
                    'no_hp' => $faker->numerify('08##########'), // <-- PENAMBAHAN NO HP DI SINI
                    'status_aktif' => 'Aktif',
                ]);
            }

            // ==========================================
            // 3. SEEDER GURU LENGKAP
            // ==========================================
            $guruIds = [];

            for ($i = 1; $i <= 40; $i++) {
                $isAktif = $i <= 35;
                $statusEnum = $isAktif ? 'Aktif' : 'Tidak Aktif';

                $userGuru = User::create([
                    'name'      => $faker->name,
                    'email'     => 'guru' . $i . '@smpn4.com',
                    'password'  => $passwordStandar,
                    'role'      => 'guru',
                    'is_active' => $isAktif,
                ]);

                $nip = $faker->unique()->numerify('198#########');
                $guru = Guru::create([
                    'user_id'        => $userGuru->id,
                    'nip'            => $nip,
                    'nama_lengkap'   => $userGuru->name,
                    'gelar_depan'    => '',
                    'gelar_belakang' => $faker->randomElement(['S.Pd', 'S.Kom', 'M.Pd']),
                    'jenis_kelamin'  => $faker->randomElement(['L', 'P']),
                    'tempat_lahir'   => $faker->city,
                    'tanggal_lahir'  => $faker->date('Y-m-d', '1995-01-01'),
                    'agama'          => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu']),
                    'no_hp'          => $faker->numerify('08##########'),
                    'alamat'         => $faker->address,
                    'status_aktif'   => $statusEnum,
                ]);

                DataKepegawaian::create([
                    'guru_id'         => $guru->id,
                    'status_pegawai'  => $faker->randomElement(['PNS', 'PPPK', 'Honorer']),
                    'nip'             => $nip,
                    'golongan'        => $faker->randomElement(['III/a', 'III/b', 'III/c', 'IX']),
                    'jabatan'         => 'Guru Mata Pelajaran',
                    'sk_pengangkatan' => 'SK.DISDIK/' . $faker->year . '/' . $faker->numerify('####'),
                ]);

                RiwayatPendidikan::create([
                    'guru_id'     => $guru->id,
                    'jenjang'     => 'S1',
                    'institusi'   => 'Universitas Tadulako',
                    'jurusan'     => 'Pendidikan ' . $faker->randomElement(['Matematika', 'TI', 'Bahasa', 'Sains']),
                    'tahun_lulus' => $faker->numberBetween(2010, 2023),
                ]);

                if ($isAktif) {
                    $guruIds[] = $guru->id;
                } else {
                    $guru->delete();
                }
            }

            // ==========================================
            // 4. SEEDER KELAS & SISWA
            // ==========================================
            $kelasIds = [];
            $namaKelas = ['VII Diponegoro', 'VII Pattimura', 'VIII Melati', 'VIII Mawar', 'IX Mangga'];
            $tingkat = ['7', '7', '8', '8', '9'];

            for ($i = 0; $i < 5; $i++) {
                $kelas = Kelas::create([
                    'nama_kelas'    => $namaKelas[$i],
                    'tingkat_kelas' => $tingkat[$i],
                    'guru_id'       => $faker->randomElement($guruIds),
                ]);
                $kelasIds[] = $kelas->id;
            }

            for ($i = 1; $i <= 150; $i++) {
                $idKelasAcak = $faker->randomElement($kelasIds);
                $siswa = Siswa::create([
                    'nis'           => $faker->unique()->numerify('24###'),
                    'nisn'          => $faker->unique()->numerify('01########'),
                    'nama_lengkap'  => $faker->name,
                    'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                    'tempat_lahir'  => $faker->city,
                    'tanggal_lahir' => $faker->date('Y-m-d', '2012-01-01'),
                    'agama'         => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu']),
                    'alamat'        => $faker->address,
                    'nama_wali'     => $faker->name,
                    'no_hp_wali'    => $faker->numerify('08##########'),
                    'kelas_id'      => $idKelasAcak,
                ]);
                Rombel::create(['siswa_id' => $siswa->id, 'kelas_id' => $idKelasAcak, 'tahun_ajaran_id' => $taGanjil->id]);
                Rombel::create(['siswa_id' => $siswa->id, 'kelas_id' => $idKelasAcak, 'tahun_ajaran_id' => $taGenap->id]);
            }

            DB::commit();
            $this->command->info('Data Dummy Ultimate berhasil di-seed (Pimpinan di tabel pimpinans)!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Terjadi error saat seeding: ' . $e->getMessage());
        }
    }
}
