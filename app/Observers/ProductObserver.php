<?php

namespace App\Observers;

use App\Model\Product;
use App\Services\ElasticsearchService;

class ProductObserver
{
    /**
     * @var ElasticsearchService
     */
    private $elasticsearchService;

    /**
     * @param ElasticsearchService $elasticsearchService
     */
    public function __construct(ElasticsearchService $elasticsearchService)
    {
        $this->elasticsearchService = $elasticsearchService;
    }

    /**
     * Listen to the Product created event.
     *
     * @param  Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $product->addToIndex();
    }

    /**
     * Listen to the Product updated event.
     *
     * @param  Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        if ($this->elasticsearchService->isDocumentFound($product)) {
            $product->updateIndex();
        } else {
            $product->addToIndex();
        }
    }

    /**
     * Listen to the Product deleting event.
     *
     * @param Product $products
     * @return void
     */
    public function deleting(Product $products)
    {
        if ($this->elasticsearchService->isDocumentFound($products)) {
            $products->removeFromIndex();
        }
    }
}