<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TanahKasDesa;
use App\Observers\TanahKasDesaObserver;

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
        \App\Models\TanahKasDesa::observe(\App\Observers\TanahKasDesaObserver::class);
    }
}