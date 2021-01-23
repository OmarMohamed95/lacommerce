<?php

namespace App\Services;

use App\Model\Wishlist;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use Auth;

class WishlistService
{
    /**
     * Wishlist Repository
     *
     * @var WishlistRepositoryInterface $wishlistRepository
     */
    private $wishlistRepository;

    public function __construct(WishlistRepositoryInterface $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    /**
     * Get wishlist products IDs of the current user
     *
     * @return array
     */
    public function getWishlistProductsIds(): array
    {
        return $this
            ->wishlistRepository
            ->getWishlistProductsIds(Auth::user()->id);
    }

    /**
     * Check if the product is wishlisted
     *
     * @param int $productId
     * @return bool
     */
    public function isWishlisted(int $productId): bool
    {
        return $this
            ->wishlistRepository
            ->isWishlisted(Auth::user()->id, $productId);
    }

    /**
     * Add product to the wishlist
     *
     * @param int $productId
     * @return void
     */
    public function addToWishlist(int $productId)
    {
        $wishlist = new Wishlist();
        $wishlist->product_id = $productId;
        $wishlist->user_id = Auth::user()->id;
        $wishlist->save();
    }

    /**
     * Remove product from the wishlist
     *
     * @param int $productId
     * @return void
     */
    public function removeFromWishlist(int $productId)
    {
        $this->wishlistRepository
            ->getWishlistProduct(Auth::user()->id, $productId)
            ->delete();
    }
}