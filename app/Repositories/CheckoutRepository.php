<?php

namespace App\Repositories;

use App\Model\Checkout;
use App\Repositories\Contracts\CheckoutRepositoryInterface;

class CheckoutRepository implements CheckoutRepositoryInterface
{
    /**
     * Get all checkouts
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return Checkout::all();
    }

    /**
     * Get single checkout by id
     *
     * @param int $checkoutId
     * @return Checkout
     */
    public function find(int $checkoutId)
    {
        return Checkout::find($checkoutId);
    }

    /**
     * Get checkout by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return Checkout::where($column, $value)->get();
    }
}