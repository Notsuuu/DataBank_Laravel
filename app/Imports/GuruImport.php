<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use App\Models\Pimpinan;

class GuruImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['nama_lengkap'])) {
            return null;
        }

        $jabatanExcel = strtolower($row['jabatan'] ?? '');
        $kataKunciTendik = ['layanan', 'administrasi', 'operator', 'pramubakti', 'kebersihan', 'keamanan', 'satpam', 'tata usaha', 'tekhnis', 'teknis', 'pustakawan', 'staf', 'staff', 'tu'];

        foreach ($kataKunciTendik as $tendik) {
            if (str_contains($jabatanExcel, $tendik)) {
                return null;
            }
        }

        $namaDariExcel = $row['nama_lengkap'];
        $gelarDepan = null;
        $namaLengkap = trim($namaDariExcel);
        $gelarBelakang = null; 

        if (strpos($namaLengkap, ',') !== false) {
            $parts = explode(',', $namaLengkap, 2);
            $namaLengkap = trim($parts[0]);
            $gelarBelakang = trim($parts[1]);
        }

        $daftarGelar = ['Dr.', 'Drs.', 'Dra.', 'Ir.', 'H.', 'Hj.', 'Prof.', 'Pdt.', 'Ns.'];
        $kataSatuPerSatu = explode(' ', $namaLengkap);
        $kumpulanGelarDepan = [];

        foreach ($kataSatuPerSatu as $kata) {
            if (in_array($kata, $daftarGelar)) {
                $kumpulanGelarDepan[] = $kata;
                array_shift($kataSatuPerSatu);
            } else {
                break;
            }
        }

        if (count($kumpulanGelarDepan) > 0) {
            $gelarDepan = implode(' ', $kumpulanGelarDepan);
            $namaLengkap = implode(' ', $kataSatuPerSatu);
        }

        $nip = $row['nip'] ?? null;
        $nipBersih = $nip ? str_replace([' ', '-'], '', $nip) : null; 
        if ($nipBersih === '') {
            $nipBersih = null; 
        }

        $pangkatGol = $row['pangkat_gol'] ?? null;
        $jabatanExcel = $row['jabatan'] ?? null;
        $statusPegawai = $row['status_pegawai'] ?? 'Honorer';
        $noHp = $row['no_hp'] ?? null;


        $emailPrefix = $nipBersih ? $nipBersih : Str::slug($namaLengkap) . rand(10, 99);
        $emailExcel = $emailPrefix . '@smpn4palu.com';
        $passwordAkun = $nipBersih ? $nipBersih : 'smpn4palu';

        if (User::where('email', $emailExcel)->exists()) {
            return null; 
        }


        $jabatanLower = strtolower($jabatanExcel ?? '');
        $isPimpinan = str_contains($jabatanLower, 'kepala') || str_contains($jabatanLower, 'wakil') || str_contains($jabatanLower, 'wakasek') || str_contains($jabatanLower, 'kepsek') || str_contains($jabatanLower, 'kasek');

        $user = User::create([
            'name' => $namaLengkap,
            'email' => $emailExcel,
            'password' => Hash::make($passwordAkun),
            'role' => $isPimpinan ? 'pimpinan' : 'guru', 
            'is_active' => true,
            'force_change_password' => true, 
        ]);

        $dataPegawai = [
            'user_id'        => $user->id,
            'nip'            => $nipBersih,
            'nama_lengkap'   => $namaLengkap,
            'gelar_depan'    => $gelarDepan,
            'gelar_belakang' => $gelarBelakang,
            'pangkat_gol'    => $pangkatGol,
            'jabatan'        => $jabatanExcel,
            'status_pegawai' => $statusPegawai,
            'no_hp'          => $noHp,
            'status_aktif'   => 'Aktif',
            'jenis_kelamin'  => null, 
            'tempat_lahir'   => null,
            'tanggal_lahir'  => null,
            'agama'          => null,
            'alamat'         => null,
        ];

        if ($isPimpinan) {
            return new Pimpinan($dataPegawai);
        }

        return new Guru($dataPegawai);
    }
}