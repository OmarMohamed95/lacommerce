<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\CheckoutOccur;
use App\Events\CheckoutDone;
use App\Listeners\ProductEventSubscriber;
use App\Listeners\UpdateProductQuantity;
use App\Listeners\RemoveCart;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CheckoutOccur::class => [
            UpdateProductQuantity::class,
        ],
        CheckoutDone::class => [
            RemoveCart::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        ProductEventSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
