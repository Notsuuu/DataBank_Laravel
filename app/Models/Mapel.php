<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CatatLogAktivitas;

class Mapel extends Model
{
    use HasFactory, CatatLogAktivitas;

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kelompok_mapel'
    ];
}
