<?php

namespace App\Http\Controllers\Api;

use App\Services\WishlistService;

class WishlistController extends BaseController
{
    /**
     * @var WishlistService
     */
    private $wishlistService;

    /**
     * @param WishlistService $wishlistService
     */
    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
        $this->middleware('auth');
    }

    /**
     * Store action
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $productId)
    {
        $isWishlisted = $this->wishlistService->isWishlisted($productId);

        if ($isWishlisted) {
            return $this->respondJson(
                [
                    'message' => __('messages.wishlist.product_already_exist')
                ],
                409
            );
        }

        $this->wishlistService->addToWishlist($productId);
        
        return $this->respondJson(
            [
                'message' => __('messages.wishlist.product_added_successfully')
            ],
            201
        );

    }

    /**
     * Delete product from wishlist
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $productId)
    {
        $this->wishlistService->removeFromWishlist($productId);
        
        return $this->respondJson(
            [
                'message' => __('messages.wishlist.product_removed'),
                'id' => $productId
            ]
        );
    }
}
