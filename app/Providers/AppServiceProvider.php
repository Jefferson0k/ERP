<?php

namespace App\Providers;

use App\Services\CavaliService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(){
        $this->app->singleton(CavaliService::class, function ($app) {
            return new CavaliService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
