<?php

namespace App\Services;

use App\Model\Cart;
use App\Model\Product;
use App\Repositories\Contracts\CartRepositoryInterface;
use Auth;
use Illuminate\Database\Eloquent\Builder;

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
     * @param Product $product
     * @param Cart|null $cartProduct
     * @return boolean
     */
    public function canAddProductToCart(Product $product, $cartProduct): bool
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

    /**
     * Get cart of current user
     *
     * @return Cart
     */
    public function getCart()
    {
        return $this->cartRepository->findBy('user_id', Auth::user()->id);
    }

    /**
     * Get cart query of current user
     *
     * @return Builder
     */
    public function getCartQuery(): Builder
    {
        return $this->cartRepository->getCartQuery(Auth::user()->id);
    }
}