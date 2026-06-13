<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Gunakan ini jika kamu pakai style PHP 8 Attribute seperti di model User
// use Illuminate\Database\Eloquent\Attributes\Fillable;

class Pimpinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nip',
        'gelar_depan',
        'gelar_belakang',
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'status_aktif',
        'pangkat_gol',
        'jabatan',
        'status_pegawai',
        'foto',        
        'file_ktp',    
        'file_ijazah', 
        'file_sk'     
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function riwayatPendidikans()
    {
        return $this->hasMany(RiwayatPendidikan::class);
    }
}
