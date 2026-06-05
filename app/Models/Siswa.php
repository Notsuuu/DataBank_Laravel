<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CatatLogAktivitas;

class Siswa extends Model
{
    use HasFactory, CatatLogAktivitas;

    // Menggabungkan semua kolom fillable dari kedua versi
    protected $fillable = [
        'nis',
        'nisn',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'nama_wali',
        'no_hp_wali',
        'foto',
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

    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'siswa_id');
    }
}
