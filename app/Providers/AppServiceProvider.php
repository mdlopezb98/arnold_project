<?php

namespace App\Providers;

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
        //global variable
        view()->composer('layouts.template', function($view){

            $saludo = 'Hi world';

            $view->with(['constante' => $saludo]);

            });
    }

}
