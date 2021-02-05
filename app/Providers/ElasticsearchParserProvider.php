<?php

namespace App\Providers;

use App\Contracts\ElasticsearchParserInterface;
use App\Services\ElasticsearchParser;
use Illuminate\Support\ServiceProvider;

class ElasticsearchParserProvider extends ServiceProvider
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
            ElasticsearchParserInterface::class,
            ElasticsearchParser::class
        );
    }
}
