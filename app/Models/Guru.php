<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    // "Satpam" yang mengizinkan kolom-kolom ini diisi melalui API
    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'gelar_depan',
        'gelar_belakang',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'no_hp',
        'alamat',
        'foto'
    ];

    /**
     * Relasi: Satu profil Guru dimiliki oleh satu akun User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
