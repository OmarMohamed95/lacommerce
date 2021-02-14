<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\App\cartRequest;
use App\Model\Cart;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends BaseController
{
    /**
     * Cart Repository
     *
     * @var CartRepositoryInterface $cartRepository
     */
    private $cartRepository;
    
    /**
     * Cart Service
     *
     * @var CartService $cartService
     */
    private $cartService;
    
    /**
     * Product repository
     *
     * @var ProductRepositoryInterface $productRepository
     */
    private $productRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CartService $cartService,
        ProductRepositoryInterface $productRepository
    ) {
        $this->middleware('auth');
        $this->cartRepository = $cartRepository;
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
    }

    /**
     * Store product in cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $userId = Auth::guard('api')->user()->id;

        $cartProduct = $this
            ->cartService
            ->getCartProductByUser($request->productId, $userId);
        
        $product = $this->productRepository->find($request->productId);

        if (!$this->cartService->canAddProductToCart($product, $cartProduct)) {
            return $this->respondNoContent();
        }

        if ($cartProduct) {
            $cartProduct->quantity++;
            $cartProduct->save();
        } else {
            $cart = new Cart();
            $cart->product_id = $request->productId;
            $cart->user_id = $userId;
            $cart->quantity++;
            $cart->save();
        }

        return $this->respondJson(
            [
                'redirect' => route('cart_index', ['id' => $userId])
            ],
            201
        );
    }

    /**
     * Delete product from cart
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $productId)
    {
        $this
            ->cartService
            ->getCartProductByUser($productId, Auth::guard('api')->user()->id)
            ->delete();
        
        return $this->respondJson(
            [
                'message'=> __('messages.cart.delete_success_message'),
                'id' => $productId
            ]
        );
    }

    /**
     * Get cart total price
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalPrice()
    {
        $totalPrice = $this
            ->cartService
            ->getTotalCartPrice(Auth::guard('api')->user()->id);

        if (!$totalPrice) {
            return $this->respondNoContent();
        }

        return $this->respondJson(['totalPrice' => $totalPrice]);
    }

    /**
     * Update product quantity in cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQuantity(cartRequest $request)
    {
        $cartProduct = $this->cartService->getCartProductByUser(
            $request->productId,
            Auth()->user()->id
        );
        $cartProduct->quantity = $request->quantity;
        $cartProduct->save();
        return $this->respondNoContent();
    }
}
