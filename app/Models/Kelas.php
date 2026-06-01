<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    // Pastikan Laravel tahu nama tabelnya persis 'kelas' (bukan kelasses/kelas_s)
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas', 'tingkat', 'wali_kelas_id'];

    /**
     * Relasi: Satu Kelas punya satu Guru sebagai Wali Kelas
     */
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }
}
