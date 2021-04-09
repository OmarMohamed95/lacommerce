<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\OrderOccur;
use App\Events\OrderDone;
use App\Jobs\TestJob;
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
        OrderOccur::class => [
            UpdateProductQuantity::class,
        ],
        OrderDone::class => [
            RemoveCart::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->app->bind(
            SendOrderStatusEmail::class . '@handle', function ($job) { 
                return $job->handle();
            }
        );
    }
}
