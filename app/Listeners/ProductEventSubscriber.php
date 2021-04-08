<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Events\ProductDeleted;
use App\Events\ProductUpdated;
use App\Model\Product;
use Elasticquent\ElasticquentCollection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductEventSubscriber
{
    /**
     * Handle product created events.
     */
    public function onProductCreated($event)
    {
        $event->getProduct()->addToIndex();
    }

    /**
     * Handle product updated events.
     */
    public function onProductUpdated($event)
    {
        $product = $event->getProduct();
        if ($this->isDocumentFound($product)) {
            $product->updateIndex();
        } else {
            $product->addToIndex();
        }
    }
    
    /**
     * Handle product deleted events.
     */
    public function onProductDeleted($event)
    {
        $products = $event->getProduct();
        if ($products instanceof ElasticquentCollection) {
            foreach ($products as $product) {
                if ($this->isDocumentFound($product)) {
                    $product->removeFromIndex();
                }
            }
        } elseif ($products instanceof Product) {
            if ($this->isDocumentFound($products)) {
                $products->removeFromIndex();
            }
        }
    }

    /**
     * Check if the document exists
     *
     * @param Product $product
     * @return bool
     */
    private function isDocumentFound(Product $product)
    {
        try {
            $isDocumentFound = $product->getIndexedDocument();
        } catch (\Exception $th) {
            $isDocumentFound = false;
        }

        return $isDocumentFound;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            ProductCreated::class,
            'App\Listeners\ProductEventSubscriber@onProductCreated'
        );

        $events->listen(
            ProductUpdated::class,
            'App\Listeners\ProductEventSubscriber@onProductUpdated'
        );

        $events->listen(
            ProductDeleted::class,
            'App\Listeners\ProductEventSubscriber@onProductDeleted'
        );
    }
}
