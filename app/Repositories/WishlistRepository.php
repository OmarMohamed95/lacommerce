<?php

namespace App\Repositories;

use App\Model\Wishlist;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use DB;

class WishlistRepository implements WishlistRepositoryInterface
{
    /**
     * Get all wishlists
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return Wishlist::all();
    }

    /**
     * Get single wishlist by id
     *
     * @param int $wishlistId
     * @return Wishlist
     */
    public function find(int $wishlistId)
    {
        Wishlist::find($wishlistId);
    }

    /**
     * Get wishlists by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return Wishlist::where($column, $value)->get();
    }

    /**
     * Get wishlist products IDs by user ID
     *
     * @param int $userId
     * @return array
     */
    public function getWishlistProductsIds(int $userId): array
    {
        return DB::table('wishlists')
            ->where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();
    }

    /**
     * Check if the product is wishlisted
     *
     * @param int $productId
     * @param int $userId
     * @return bool
     */
    public function isWishlisted(int $userId, int $productId): bool
    {
        return Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->select('product_id')
            ->first() ? true : false;
    }
}