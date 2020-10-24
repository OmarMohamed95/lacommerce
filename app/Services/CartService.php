<?php

namespace App\Services;

use App\adminModel\cart;
use App\adminModel\product;
use App\Repositories\Contracts\CartRepositoryInterface;

class CartService
{
    /**
     * Cart Repository
     *
     * @var CartRepositoryInterface $cartRepository
     */
    private $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Check if a product available to be added to cart
     *
     * @param product $product
     * @param cart|null $cartProduct
     * @return boolean
     */
    public function canAddProductToCart(product $product, $cartProduct): bool
    {
        if (($product->quantity > 0 && !$cartProduct)
            || ($product->quantity > 0
            && $cartProduct
            && $cartProduct->quantity < $product->quantity)
        ) {
            return true;
        }
        return false;
    }

    /**
     * Get single cart product by user
     *
     * @param int $productId
     * @param int $userId
     * @return Illuminate\Support\Collection
     */
    public function getCartProductByUser(int $productId, int $userId)
    {
        return $this->cartRepository->findByCriteria(
            [
                'userId' => $userId,
                'productId' => $productId,
            ],
            true
        );
    }
}