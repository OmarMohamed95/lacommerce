<?php

namespace App\Repositories\Contracts;
use Elasticquent\ElasticquentResultCollection;

interface ProductElasticsearchRepositoryInterface
{
    /**
     * Search query
     *
     * @param string $query
     * 
     * @return ElasticquentResultCollection
     */
    public function search($query): ElasticquentResultCollection;
}