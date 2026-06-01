<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CatatLogAktivitas;

class TahunAjaran extends Model
{
    use HasFactory, CatatLogAktivitas;

    protected $fillable = [
        'tahun',
        'semester',
        'is_active'
    ];
}
