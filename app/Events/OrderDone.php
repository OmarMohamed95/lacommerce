<?php

namespace App\Events;

use App\Model\Cart;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Builder;

class OrderDone
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Cart Builder instance
     *
     * @var Builder
     */
    private $cart;

    /**
     * Create a new event instance.
     *
     * @param Builder $cart
     * @return void
     */
    public function __construct(Builder $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Get cart Builder instance.
     *
     * @return Builder
     */
    public function getCart(): Builder
    {
        return $this->cart;
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
