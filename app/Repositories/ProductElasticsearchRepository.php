<?php

namespace App\Repositories;

use App\Model\Product;
use App\Repositories\Contracts\ProductElasticsearchRepositoryInterface;
use Elasticquent\ElasticquentResultCollection;

class ProductElasticsearchRepository implements ProductElasticsearchRepositoryInterface
{
    /**
     * Search query
     *
     * @param string $query
     * 
     * @return ElasticquentResultCollection
     */
    public function search($query): ElasticquentResultCollection
    {
        return Product::searchByQuery(
            [
                'match' => [
                    'name' => $query
                ]
            ],
            null,
            ['id', 'name', 'category'],
            10
        );
    }
}