<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CatatLogAktivitas;

class Guru extends Model
{
    use HasFactory, CatatLogAktivitas;

    protected $fillable = [
        'user_id', 'nip', 'nuptk', 'nama_lengkap', 'gelar_depan', 'gelar_belakang', 
        'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'no_hp', 'alamat', 
        'foto', 'status_aktif'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function kepegawaian() { return $this->hasOne(DataKepegawaian::class); }
    public function riwayatPendidikan() { return $this->hasMany(RiwayatPendidikan::class); }
    public function berkas() { return $this->hasMany(BerkasGuru::class); }

    // RELASI DIPERBAIKI: Menggunakan guru_id
    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'guru_id', 'id');
    }
}