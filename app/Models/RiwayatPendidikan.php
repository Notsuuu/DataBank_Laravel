<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CatatLogAktivitas;

class RiwayatPendidikan extends Model
{
    use HasFactory, CatatLogAktivitas;

    protected $fillable = [
        'guru_id',
        'pimpinan_id',
        'jenjang',
        'institusi',
        'jurusan',
        'tahun_lulus'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function pimpinan()
    {
        return $this->belongsTo(Pimpinan::class);
    }
}
