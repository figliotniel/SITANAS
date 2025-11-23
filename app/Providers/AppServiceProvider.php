<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TanahKasDesa;
use App\Observers\TanahKasDesaObserver;
<<<<<<< HEAD
=======
use Illuminate\Pagination\Paginator;
>>>>>>> 489b41eeaee4e3396c74feb7f1bc92bd40f53897

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
<<<<<<< HEAD
        // Daftarkan Observer di sini agar pasti terbaca
        TanahKasDesa::observe(TanahKasDesaObserver::class);
=======
        // Mengaktifkan Observer untuk TanahKasDesa
        TanahKasDesa::observe(TanahKasDesaObserver::class);

        // Opsional: Menggunakan Bootstrap 5 untuk pagination (agar tampilan log di admin rapi)
        Paginator::useBootstrapFive();
>>>>>>> 489b41eeaee4e3396c74feb7f1bc92bd40f53897
    }
}