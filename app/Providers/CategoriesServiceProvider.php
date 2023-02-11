<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CategoriesService;

class CategoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CategoriesService::class, function ($app) {
            return new CategoriesService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
