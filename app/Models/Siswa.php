<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes; 

    protected $guarded = ['id'];
    
    protected $fillable = [
        'nis', 'nisn', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 
        'tanggal_lahir', 'agama', 'alamat', 'nama_wali', 'no_hp_wali', 
        'foto', 'kelas_id'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'siswa_id');
    }
}