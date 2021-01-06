<?php

namespace App\Listeners;

use App\Events\CheckoutDone;
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
     * @param  CheckoutDone  $event
     * @return void
     */
    public function handle(CheckoutDone $event)
    {
        $cart = $event->getCart();
        $cart->delete();
    }
}
