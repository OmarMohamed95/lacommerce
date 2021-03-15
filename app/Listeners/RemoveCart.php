<?php

namespace App\Listeners;

use App\Events\OrderDone;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveCart
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderDone  $event
     * @return void
     */
    public function handle(OrderDone $event)
    {
        $cart = $event->getCart();
        $cart->delete();
    }
}
