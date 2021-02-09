<?php

namespace App\Events;

use App\Model\Product;
use Elasticquent\ElasticquentCollection;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Product model
     *
     * @var Product $product
     */
    private $product;

    /**
     * Create a new event instance.
     *
     * @param Product|ElasticquentCollection $product
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Get product instance.
     *
     * @return Product|ElasticquentCollection
     */
    public function getProduct()
    {
        return $this->product;
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
