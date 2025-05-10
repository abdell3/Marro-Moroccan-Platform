<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        // Utiliser notre vue de pagination personnalisée
        Paginator::defaultView('pagination.simple');
        
        // Ou utiliser Bootstrap (décommenté pour utiliser Bootstrap)
        // Paginator::useBootstrap();
    }
}
