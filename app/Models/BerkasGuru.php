<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasGuru extends Model
{
    use HasFactory;

    // INI DIA KUNCI GERBANGNYA 🔑
    protected $fillable = [
        'guru_id',
        'jenis_berkas',
        'file_path',
    ];

    /**
     * Relasi balik: Satu berkas dimiliki oleh satu Guru.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
