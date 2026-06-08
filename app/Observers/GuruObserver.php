<?php

namespace App\Observers;

use App\Models\Guru;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class GuruObserver
{
    public function created(Guru $guru): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),    
            'aksi' => 'CREATE',
            'entitas' => 'Guru',
            'data_baru' => ['nama' => $guru->nama_lengkap, 'nip' => $guru->nip]
        ]);
    }

    public function updated(Guru $guru): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'UPDATE',
            'entitas' => 'Guru',
            'data_lama' => ['nama' => $guru->getOriginal('nama_lengkap')],
            'data_baru' => ['nama' => $guru->nama_lengkap]
        ]);
    }

    public function deleted(Guru $guru): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'DELETE',
            'entitas' => 'Guru',
            'data_lama' => ['nama' => $guru->nama_lengkap, 'nip' => $guru->nip]
        ]);
    }
}