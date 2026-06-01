<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendidikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'jenjang',
        'institusi',
        'jurusan',
        'tahun_lulus'
    ];

    /**
     * Relasi balik: Riwayat Pendidikan ini milik satu Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
