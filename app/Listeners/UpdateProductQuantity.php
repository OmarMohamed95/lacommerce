<?php

namespace App\Listeners;

use App\Events\CheckoutOccur;
use App\Events\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProductQuantity
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
     * @param  Event  $event
     * @return void
     */
    public function handle(CheckoutOccur $event)
    {
        $product = $event->getProduct();
        $cartQuantity = $event->getCartProductQuantity();

        $product->quantity = $product->quantity - $cartQuantity;
        if ($cartQuantity > $product->quantity) {
            $product->quantity = 0;
        }
        $product->save();
    }
}
