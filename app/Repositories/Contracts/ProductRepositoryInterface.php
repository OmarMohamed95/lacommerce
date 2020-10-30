<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    /**
     * Get all products
     *
     * @return Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get single product by id
     *
     * @param int $productId
     * @return product
     */
    public function find(int $productId);

    /**
     * Get product by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     */
    public function findBy(string $column, $value);
}