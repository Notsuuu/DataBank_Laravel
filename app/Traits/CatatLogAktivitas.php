<?php

namespace App\Traits;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

trait CatatLogAktivitas
{
    /**
     * Laravel akan otomatis menjalankan fungsi boot[NamaTrait] ini
     * setiap kali Model dipanggil.
     */
    protected static function bootCatatLogAktivitas()
    {
        // Deteksi saat data BARU SAJA dibuat
        static::created(function ($model) {
            self::rekamLog('CREATE', $model, null, $model->toArray());
        });

        // Deteksi saat data BARU SAJA diubah
        static::updated(function ($model) {
            // getChanges() hanya mengambil kolom yang berubah saja
            self::rekamLog('UPDATE', $model, $model->getOriginal(), $model->getChanges());
        });

        // Deteksi saat data BARU SAJA dihapus
        static::deleted(function ($model) {
            self::rekamLog('DELETE', $model, $model->toArray(), null);
        });
    }

    protected static function rekamLog($aksi, $model, $dataLama, $dataBaru)
    {
        LogAktivitas::create([
            'user_id'   => Auth::id(), // Deteksi user yang sedang login via token
            'aksi'      => $aksi,
            'entitas'   => class_basename($model), // Contoh: menghasilkan teks "Guru" atau "Siswa"
            'data_lama' => $dataLama ? json_encode($dataLama) : null,
            'data_baru' => $dataBaru ? json_encode($dataBaru) : null,
        ]);
    }
}
