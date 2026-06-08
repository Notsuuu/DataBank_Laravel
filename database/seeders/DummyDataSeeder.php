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
use App\Models\BerkasGuru;

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
            $taGenap  = TahunAjaran::create(['tahun' => '2025/2026', 'semester' => 'Genap', 'is_active' => 1]); // Yang aktif saat ini

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

            for ($i = 1; $i <= 5; $i++) {
                User::create(['name' => 'Pimpinan ' . $i, 'email' => 'pimpinan' . $i . '@smpn4.com', 'password' => $passwordStandar, 'role' => 'pimpinan', 'is_active' => 1]);
            }

            // ==========================================
            // 3. SEEDER GURU LENGKAP (Data Pegawai, Pendidikan, Berkas)
            // ==========================================
            $guruIds = [];

            for ($i = 1; $i <= 40; $i++) {
                $isAktif = $i <= 35;
                $statusEnum = $isAktif ? 'Aktif' : 'Tidak Aktif';

                // Akun
                $userGuru = User::create([
                    'name'      => $faker->name,
                    'email'     => 'guru' . $i . '@smpn4.com',
                    'password'  => $passwordStandar,
                    'role'      => 'guru',
                    'is_active' => $isAktif,
                ]);

                // Profil Guru
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

                // Detail Kepegawaian
                DataKepegawaian::create([
                    'guru_id'         => $guru->id,
                    'status_pegawai'  => $faker->randomElement(['PNS', 'PPPK', 'Honorer']),
                    'nip'             => $nip,
                    'golongan'        => $faker->randomElement(['III/a', 'III/b', 'III/c', 'IX']),
                    'jabatan'         => 'Guru Mata Pelajaran',
                    'sk_pengangkatan' => 'SK.DISDIK/' . $faker->year . '/' . $faker->numerify('####'),
                ]);

                // Riwayat Pendidikan
                RiwayatPendidikan::create([
                    'guru_id'     => $guru->id,
                    'jenjang'     => 'S1',
                    'institusi'   => 'Universitas Tadulako',
                    'jurusan'     => 'Pendidikan ' . $faker->randomElement(['Matematika', 'TI', 'Bahasa', 'Sains']),
                    'tahun_lulus' => $faker->numberBetween(2010, 2023),
                ]);

                // Berkas (Dummy path)
                //BerkasGuru::create([
                //    'guru_id'      => $guru->id,
                //    'jenis_berkas' => 'Ijazah S1',
                //    'file_path'    => 'berkas/ijazah_dummy.pdf',
                //]);

                if ($isAktif) {
                    $guruIds[] = $guru->id;
                } else {
                    $guru->delete(); // Soft Delete 5 guru
                }
            }

            // ==========================================
            // 4. SEEDER KELAS
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

            // ==========================================
            // 5. SEEDER SISWA & ROMBEL
            // ==========================================
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

                // Daftarkan siswa ke Rombel di Tahun Ajaran Ganjil & Genap
                Rombel::create(['siswa_id' => $siswa->id, 'kelas_id' => $idKelasAcak, 'tahun_ajaran_id' => $taGanjil->id]);
                Rombel::create(['siswa_id' => $siswa->id, 'kelas_id' => $idKelasAcak, 'tahun_ajaran_id' => $taGenap->id]);
            }

            DB::commit();
            $this->command->info('Data Dummy Ultimate berhasil di-seed: Operator, Pimpinan, Guru (Pendidikan, Karir, Berkas), Kelas, Siswa, Rombel, & Mapel!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Terjadi error saat seeding: ' . $e->getMessage());
        }
    }
}
