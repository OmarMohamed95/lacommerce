<?php

namespace App\Contracts;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\App;

abstract class FilterInterface
{
    /**
     * Product repository
     *
     * @var ProductRepositoryInterface $productRepository
     */
    private $productRepository;

    public function getRepository()
    {
        return $this->productRepository = App::make(ProductRepositoryInterface::class);
    }

    /**
     * Filter results
     *
     * @param Builder $qb
     * @param mixed $value
     * @return Builder
     */
    public abstract function filter(Builder $qb, $value): Builder;
}