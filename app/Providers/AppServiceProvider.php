<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Importe esta classe

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
        // Adicione esta linha:
        Paginator::useTailwind(); // Ou Paginator::useBootstrapFive(); se estiver a usar Bootstrap 5
    }
}