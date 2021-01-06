<?php

namespace App\Repositories\Contracts;

use App\Model\Checkout;

interface CheckoutRepositoryInterface
{
    /**
     * Get all checkouts
     *
     * @return Checkout[]
     */
    public function all();

    /**
     * Get single checkout by id
     *
     * @param int $checkoutId
     * @return Checkout
     */
    public function find(int $checkoutId);

    /**
     * Get checkout by column
     *
     * @param string $column
     * @param mixed $value
     * @return Checkout
     */
    public function findBy(string $column, $value);
}