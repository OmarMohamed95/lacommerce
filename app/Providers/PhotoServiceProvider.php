<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PhotoService;
use Illuminate\Http\Request;

class PhotoServiceProvider extends ServiceProvider
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
            'App\Contracts\PhotoServiceInterface',
            function () {
                $request = $this->app->make(Request::class);
                return new PhotoService($request);
            }
        );
    }
}
