<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // Mengizinkan pengisian data massal (Mass Assignment)
    protected $fillable = [
        'nisn', 
        'nis', 
        'nama_lengkap', 
        'jenis_kelamin', 
        'kelas_id'
    ];

    /**
     * Relasi ke model Kelas
     * Siswa milik satu kelas (belongsTo)
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}