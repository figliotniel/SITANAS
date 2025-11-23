<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TanahKasDesa;
use App\Observers\TanahKasDesaObserver;
use Illuminate\Pagination\Paginator;

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

        // Daftarkan Observer di sini agar pasti terbaca
        TanahKasDesa::observe(TanahKasDesaObserver::class);
        // Mengaktifkan Observer untuk TanahKasDesa
        TanahKasDesa::observe(TanahKasDesaObserver::class);

        // Opsional: Menggunakan Bootstrap 5 untuk pagination (agar tampilan log di admin rapi)
        Paginator::useBootstrapFive();
    }
}