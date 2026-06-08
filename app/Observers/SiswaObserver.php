<?php

namespace App\Observers;

use App\Models\Siswa;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class SiswaObserver
{
    public function created(Siswa $siswa): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'CREATE',
            'entitas' => 'Siswa',
            'data_baru' => ['nama' => $siswa->nama_lengkap, 'nis' => $siswa->nis]
        ]);
    }

    public function updated(Siswa $siswa): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'UPDATE',
            'entitas' => 'Siswa',
            'data_lama' => ['nama' => $siswa->getOriginal('nama_lengkap')],
            'data_baru' => ['nama' => $siswa->nama_lengkap]
        ]);
    }

    public function deleted(Siswa $siswa): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'DELETE',
            'entitas' => 'Siswa',
            'data_lama' => ['nama' => $siswa->nama_lengkap, 'nis' => $siswa->nis]
        ]);
    }
}