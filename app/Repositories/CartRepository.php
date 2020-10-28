<?php

namespace App\Repositories;

use App\Model\Cart;
use App\Repositories\Contracts\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    /**
     * Get all carts
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return Cart::all();
    }

    /**
     * Get single cart by id
     *
     * @param int $cartId
     * @return Cart
     */
    public function find(int $cartId)
    {
        return Cart::find($cartId);
    }

    /**
     * Get cart by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return Cart::where($column, $value)->get();
    }

    /**
     * Get cart by criteria
     *
     * @param array $criteria
     * @param bool $single
     * @return Illuminate\Support\Collection|Cart
     * @throws QueryException
     */
    public function findByCriteria(array $criteria, bool $single = false)
    {
        $queryBuilder = Cart::query();

        if (isset($criteria['userId'])) {
            $queryBuilder->where('user_id', $criteria['userId']);
        }

        if (isset($criteria['productId'])) {
            $queryBuilder->where('product_id', $criteria['productId']);
        }

        if (isset($criteria['quantity'])) {
            $queryBuilder->where('quantity', $criteria['quantity']);
        }

        if (isset($criteria['createdAt'])) {
            $queryBuilder->where('created_at', $criteria['createdAt']);
        }

        if ($single) {
            return $queryBuilder->first();
        }
        return $queryBuilder->get();

    }
}