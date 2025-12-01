<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'tanah/*',      // Contoh: membolehkan semua URL yang diawali 'tanah/'
            'input-data',   // Contoh lain, sesuaikan dengan route kamu
            'api/*',        // Membolehkan semua route API
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();