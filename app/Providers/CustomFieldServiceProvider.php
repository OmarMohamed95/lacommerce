<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CustomFieldService;

class CustomFieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CustomFieldService::class
        );
    }
}
