<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    protected ?TahunAjaran $tahunAktif;
    protected array $kelasCache = []; 

    public function __construct()
    {
        $this->tahunAktif = TahunAjaran::where('is_active', true)->first();
    }

    public function model(array $row)
    {
        if (empty($row['nama_siswa']) && empty($row['nama'])) {
            return null; 
        }

        $namaSiswa = trim($row['nama_siswa'] ?? $row['nama'] ?? '');
        $nis = $row['nis'] ?? null;
        $nisn = $row['nisn'] ?? null;

        $nisnBersih = $nisn ? str_replace(' ', '', $nisn) : null;
        $nisBersih = $nis ? str_replace(' ', '', $nis) : null;

        $namaRombelExcel = trim($row['rombel_saat_ini'] ?? $row['rombel'] ?? '');
        $kelasId = $this->cariAtauBuatKelas($namaRombelExcel);

        $tanggalLahir = null;
        if (!empty($row['tanggal_lahir'])) {
            if (is_numeric($row['tanggal_lahir'])) {
                $tanggalLahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');
            } else {
                $tanggalLahir = $row['tanggal_lahir']; 
            }
        }

        $dataSiswa = [
            'kelas_id'      => $kelasId, 
            'nama_lengkap'  => $namaSiswa,
            'nis'           => $nisBersih,
            'jenis_kelamin' => $row['jk'] ?? $row['jenis_kelamin'] ?? null,
            'nisn'          => $nisnBersih,
            'tempat_lahir'  => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $tanggalLahir,
            'nik'           => $row['nik'] ?? null,
            'agama'         => $row['agama'] ?? null,
            
            'alamat'        => $row['alamat'] ?? null,
            'rt'            => $row['rt'] ?? null,
            'rw'            => $row['rw'] ?? null,
            'kelurahan'     => $row['kelurahan'] ?? null,
            'kecamatan'     => $row['kecamatan'] ?? null,
            'kode_pos'      => $row['kode_pos'] ?? null,
            
            'no_hp_siswa'   => $row['hp'] ?? $row['no_hp'] ?? null,
            
            'nama_ayah'     => $row['nama_ayah'] ?? null,
            'pekerjaan_ayah'=> $row['pekerjaan_ayah'] ?? null,
            'nama_ibu'      => $row['nama_ibu'] ?? null,
            'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? null,
            
            'status_aktif'  => 'Aktif',
        ];

        $siswa = Siswa::where(function($q) use ($nisnBersih, $nisBersih) {
            if ($nisnBersih) $q->where('nisn', $nisnBersih);
            if ($nisBersih) $q->orWhere('nis', $nisBersih);
        })->first();

        if ($siswa) {
            $siswa->update($dataSiswa);
        } else {
            $siswa = Siswa::create($dataSiswa);
        }

        if ($kelasId && $this->tahunAktif) {
            Rombel::updateOrCreate([
                'siswa_id'        => $siswa->id,
                'tahun_ajaran_id' => $this->tahunAktif->id,
            ], [
                'kelas_id'        => $kelasId,
            ]);
        }

        return $siswa;
    }

    /**
     * Fungsi Helper: Cari kelas. Jika tidak ada, langsung buatkan di database.
     */
    private function cariAtauBuatKelas(?string $namaRombelExcel): ?int
    {
        if ($namaRombelExcel === '') return null;

        if (array_key_exists($namaRombelExcel, $this->kelasCache)) {
            return $this->kelasCache[$namaRombelExcel];
        }

        $potonganKata = explode(' ', $namaRombelExcel, 2);
        
        $tingkat = '-';
        $namaKelasSaja = $namaRombelExcel;

        if (count($potonganKata) === 2) {
            $tingkat = $potonganKata[0];
            $namaKelasSaja = $potonganKata[1];
        }

        $kelas = Kelas::where(function($q) use ($tingkat, $namaKelasSaja, $namaRombelExcel) {
            $q->where('tingkat_kelas', $tingkat)->where('nama_kelas', $namaKelasSaja);
        })->orWhere('nama_kelas', $namaRombelExcel)->first();

        if (!$kelas) {
            $kelas = Kelas::create([
                'tingkat_kelas' => $tingkat,
                'nama_kelas'    => $namaKelasSaja,
                'guru_id'       => null 
            ]);
        }

        $this->kelasCache[$namaRombelExcel] = $kelas->id;

        return $kelas->id;
    }
}