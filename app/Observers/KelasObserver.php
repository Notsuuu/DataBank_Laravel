<?php

namespace App\Observers;

use App\Models\Kelas;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class KelasObserver
{
    public function created(Kelas $kelas): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'CREATE',
            'entitas' => 'Kelas',
            'data_baru' => ['nama' => $kelas->nama_kelas]
        ]);
    }

    public function updated(Kelas $kelas): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'UPDATE',
            'entitas' => 'Kelas',
            'data_lama' => ['nama' => $kelas->getOriginal('nama_kelas')],
            'data_baru' => ['nama' => $kelas->nama_kelas]
        ]);
    }

    public function deleted(Kelas $kelas): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'DELETE',
            'entitas' => 'Kelas',
            'data_lama' => ['nama' => $kelas->nama_kelas]
        ]);
    }
}