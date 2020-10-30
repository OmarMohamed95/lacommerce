<?php

namespace App\Services;

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
}