<?php

namespace App\Exports;

use App\Models\Guru;
use App\Models\Pimpinan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class GuruExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected string $type;

    public function __construct(string $type = 'all')
    {
        $this->type = trim($type);
    }

    public function collection()
    {
        $data = collect();

        if ($this->type === 'all' || $this->type === 'pimpinan') {
            $pimpinans = Pimpinan::with('user')
                ->where('status_aktif', 'Aktif')
                ->get();
                
            foreach ($pimpinans as $p) {
                $data->push($this->formatDataJadiArray($p, 'Pimpinan / Kepala Sekolah'));
            }
        }

        if ($this->type === 'all' || $this->type === 'guru') {
            $gurus = Guru::with('user')
                ->where('status_aktif', 'Aktif')
                ->whereHas('user', function ($q) {
                    $q->where('role', 'guru');
                })
                ->get();
                
            foreach ($gurus as $g) {
                $data->push($this->formatDataJadiArray($g, 'Guru / Tenaga Pendidik'));
            }
        }

        return $data; 
    }

    /**
     * @param mixed $row
     * @param string $jabatan
     * @return array
     */
    private function formatDataJadiArray(mixed $row, string $jabatan): array
    {
        $nip = $row->nip;
        if (strlen((string)$nip) === 18) {
            $nipResmi = substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 1) . ' ' . substr($nip, 15, 3);
        } else {
            $nipResmi = $nip ? ' ' . $nip : '-';
        }

        $namaFinal = trim($row->gelar_depan . ' ' . $row->nama_lengkap . ' ' . $row->gelar_belakang);

        return [
            'nip'      => $nipResmi,
            'nama'     => $namaFinal,
            'email'    => $row->user->email ?? '-',
            'jabatan'  => $jabatan,
            'jk'       => $row->jenis_kelamin,
            'tempat'   => $row->tempat_lahir,
            'tanggal'  => $row->tanggal_lahir,
            'agama'    => $row->agama,
            'nohp'     => $row->no_hp ?? '-',
            'alamat'   => $row->alamat,
        ];
    }

    public function headings(): array
    {
        return [
            'NIP', 'Nama Lengkap', 'Email', 'Jabatan', 'L/P', 
            'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'No HP', 'Alamat'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map(mixed $row): array
    {
        return [
            $row['nip'],
            $row['nama'],
            $row['email'],
            $row['jabatan'],
            $row['jk'],
            $row['tempat'],
            $row['tanggal'],
            $row['agama'],
            $row['nohp'],
            $row['alamat'],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }
}