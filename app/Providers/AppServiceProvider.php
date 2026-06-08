<?php

namespace App\Providers;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Observers\GuruObserver;
use App\Observers\SiswaObserver;
use App\Observers\KelasObserver;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Guru::observe(GuruObserver::class);
        Siswa::observe(SiswaObserver::class);
        Kelas::observe(KelasObserver::class);
    }
}
