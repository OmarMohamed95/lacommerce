<?php

namespace App\Repositories\Contracts;

use App\Model\Wishlist;

interface WishlistRepositoryInterface
{
    /**
     * Get all wishlists
     *
     * @return Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get single wishlist by id
     *
     * @param int $wishlistId
     * @return Wishlist
     */
    public function find(int $wishlistId);

    /**
     * Get wishlists by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     */
    public function findBy(string $column, $value);
}