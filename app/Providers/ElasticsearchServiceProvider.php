<?php

namespace App\Providers;

use App\Services\ElasticsearchService;
use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
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
            ElasticsearchService::class
        );
    }
}
