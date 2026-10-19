<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Fuerza la URL de Codespaces para que el navegador no se vaya a localhost
        if (str_contains(config('app.url'), 'github.dev')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }
    }
}