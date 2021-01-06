<?php

namespace App\Events;

use App\Model\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CheckoutOccur
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Product model
     *
     * @var Product $product
     */
    private $product;
    
    /**
     * Cart product quantity
     *
     * @var int $cartQuantity
     */
    private $cartQuantity;

    /**
     * Create a new event instance.
     *
     * @param Product $product
     * @param int $cartQuantity
     * @return void
     */
    public function __construct(Product $product, int $cartQuantity)
    {
        $this->product = $product;
        $this->cartQuantity = $cartQuantity;
    }

    /**
     * Get product instance.
     *
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * Get cart product quantity.
     *
     * @return int
     */
    public function getCartProductQuantity(): int
    {
        return $this->cartQuantity;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
