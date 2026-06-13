<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'nip', 'nuptk', 'nama_lengkap', 'gelar_depan', 'gelar_belakang',
        'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'no_hp', 'alamat',
        'foto', 'status_aktif', 'pangkat_gol', 'jabatan', 'status_pegawai',
        'file_ktp', 'file_ijazah', 'file_sk'
    ];

    protected $guarded = ['id'];

    public function user() { return $this->belongsTo(User::class); }
    public function kepegawaian() { return $this->hasOne(DataKepegawaian::class); }
    public function riwayatPendidikan() { return $this->hasMany(RiwayatPendidikan::class); }
    

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'guru_id', 'id');
    }
}