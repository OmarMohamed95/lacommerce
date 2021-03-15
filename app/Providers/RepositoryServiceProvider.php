<?php

namespace App\Providers;

use App\Repositories\BrandRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\CartRepository;
use App\Repositories\CategoryBrandRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CategoryBrandRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\Contracts\CustomFieldRepositoryInterface;
use App\Repositories\CustomFieldRepository;
use App\Repositories\Contracts\CustomFieldCategoryRepositoryInterface;
use App\Repositories\Contracts\ProductElasticsearchRepositoryInterface;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\CustomFieldCategoryRepository;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use App\Repositories\ProductElasticsearchRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;
use App\Repositories\WishlistRepository;

class RepositoryServiceProvider extends ServiceProvider
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
            CartRepositoryInterface::class,
            CartRepository::class
        );

        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            CustomFieldRepositoryInterface::class,
            CustomFieldRepository::class
        );

        $this->app->bind(
            CustomFieldCategoryRepositoryInterface::class,
            CustomFieldCategoryRepository::class
        );

        $this->app->bind(
            WishlistRepositoryInterface::class,
            WishlistRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->bind(
            ReviewRepositoryInterface::class,
            ReviewRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            ProductElasticsearchRepositoryInterface::class,
            ProductElasticsearchRepository::class
        );

        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );

        $this->app->bind(
            CategoryBrandRepositoryInterface::class,
            CategoryBrandRepository::class
        );
    }
}
