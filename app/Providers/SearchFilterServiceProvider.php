<?php

namespace App\Providers;

use App\Contracts\SearchFilterInterface;
use App\Factory\FilterFactory;
use App\Repositories\ProductRepository;
use App\Services\SearchFilter;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class SearchFilterServiceProvider extends ServiceProvider
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
            SearchFilterInterface::class,
            function () {
                $request = $this->app->make(Request::class);
                $filterFactory = $this->app->make(FilterFactory::class);
                $productRepository = $this->app->make(ProductRepository::class);
                return new SearchFilter($request, $filterFactory, $productRepository);
            }
        );
    }
}
