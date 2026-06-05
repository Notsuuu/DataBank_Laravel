<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CatatLogAktivitas;

class DataKepegawaian extends Model
{
    use HasFactory, CatatLogAktivitas;

    // Izinkan kolom-kolom ini diisi melalui API (Controller)
    protected $fillable = [
        'guru_id',
        'status_pegawai', // Contoh: PNS, PPPK, Honorer
        'nip',
        'golongan', // Contoh: III/a, III/b, atau -
        'jabatan', // Contoh: Guru Mata Pelajaran, Kepala Sekolah
        'sk_pengangkatan'
    ];

    /**
     * Relasi balik: Data Kepegawaian ini milik satu Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
