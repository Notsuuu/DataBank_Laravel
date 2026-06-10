<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Gunakan ini jika kamu pakai style PHP 8 Attribute seperti di model User
// use Illuminate\Database\Eloquent\Attributes\Fillable;

class Pimpinan extends Model
{
    use HasFactory;

    // PASTIKAN SEMUA KOLOM INI MASUK KE FILLABLE
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
        'foto',        // <-- Wajib untuk fitur Profil
        'file_ktp',    // <-- Wajib untuk fitur Berkas
        'file_ijazah', // <-- Wajib untuk fitur Berkas
        'file_sk'      // <-- Wajib untuk fitur Berkas
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
