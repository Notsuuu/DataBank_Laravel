<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'user_id', 'nip', 'nuptk', 'nama_lengkap', 'jenis_kelamin', 
        'tempat_lahir', 'tanggal_lahir', 'agama', 'alamat', 'status_aktif'
    ];

    // Relasi ke Kelas (Menggunakan wali_kelas_id yang ada di tabel kelas)
    public function kelas()
    {
        return $this->hasOne(\App\Models\Kelas::class, 'wali_kelas_id');
    }
}