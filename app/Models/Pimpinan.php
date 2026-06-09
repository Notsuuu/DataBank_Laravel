<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pimpinan extends Model
{
    protected $table = 'pimpinans';

    protected $fillable = [
        'user_id', 'nip', 'gelar_depan', 'nama_lengkap', 'gelar_belakang',
        'jenis_kelamin', 'agama', 'tempat_lahir', 'tanggal_lahir',
        'no_hp', 'alamat', 'foto', 'status_aktif'
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
