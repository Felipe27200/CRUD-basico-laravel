<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Clase para paginar correctamente los datos en la tabla de index 
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Se va usar el método de Paginator para realizar la paginación
        Paginator::UseBootstrap();
    }
}
