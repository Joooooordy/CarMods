<?php

namespace App\Providers;

use App\Services\RdwApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(RdwApiService::class, function ($app) {
            return new RdwApiService();
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
