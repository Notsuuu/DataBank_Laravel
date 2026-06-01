<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CatatLogAktivitas;

class Siswa extends Model
{
    use HasFactory, CatatLogAktivitas;

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
        'no_hp_wali'
    ];
}
