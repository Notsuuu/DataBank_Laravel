<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CatatLogAktivitas; // Trait untuk mencatat log aktivitas

class Guru extends Model
{
    use HasFactory, CatatLogAktivitas; // Gunakan trait untuk log aktivitas

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

    public function kepegawaian()
    {
        // Satu Guru punya satu record Data Kepegawaian
        return $this->hasOne(DataKepegawaian::class);
    }

    public function riwayatPendidikan()
    {
        // Satu Guru bisa punya banyak Riwayat Pendidikan (S1, S2, dst)
        return $this->hasMany(RiwayatPendidikan::class);
    }

    public function berkas()
    {
        return $this->hasMany(BerkasGuru::class);
    }
}
