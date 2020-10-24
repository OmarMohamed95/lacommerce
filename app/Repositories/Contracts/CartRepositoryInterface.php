<?php

namespace App\Repositories\Contracts;

use App\adminModel\cart;

interface CartRepositoryInterface
{
    /**
     * Get all carts
     *
     * @return Cart[]
     */
    public function all();

    /**
     * Get single cart by id
     *
     * @param int $cartId
     * @return Cart
     */
    public function find(int $cartId);

    /**
     * Get cart by column
     *
     * @param string $column
     * @param mixed $value
     * @return Cart
     */
    public function findBy(string $column, $value);
}