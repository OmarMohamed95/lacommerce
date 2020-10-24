<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\adminModel\cart;
use App\adminModel\product;
use App\Services\CartService;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Http\Requests\App\cartRequest;

class CartController extends Controller
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

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CartService $cartService
    ) {
        $this->middleware('auth');
        $this->cartRepository = $cartRepository;
        $this->cartService = $cartService;
    }

    /**
     * Index action
     *
     * @param int $id
     * @return void
     */
    public function index(int $id)
    {
        $cartProducts = $this->cartRepository->findBy('user_id', $id);
        return view('app.cart.index')->with('cartProducts', $cartProducts);
    }

    /**
     * Update product quantity in cart
     *
     * @param Request $request
     * @return void
     */
    public function updateQuantity(cartRequest $request)
    {
        $cartProduct = $this->cartService->getCartProductByUser(
            $request->productId,
            $request->userId
        );
        $cartProduct->quantity = $request->quantity;
        $cartProduct->save();
    }

    /**
     * Store product in cart
     *
     * @param integer $productId
     * @return void
     */
    public function store(int $productId)
    {
        $userId = Auth::user()->id;

        $cartProduct = $this->cartService->getCartProductByUser($productId, $userId);
        
        $product = product::where('id', $productId)->first();

        if (!$this->cartService->canAddProductToCart($product, $cartProduct)) {
            return response()->json([], 204);
        }

        if ($cartProduct) {
            $cartProduct->quantity++;
            $cartProduct->save();
        } else {
            $cart = new cart;
            $cart->product_id = $productId;
            $cart->user_id = $userId;
            $cart->quantity++;
            $cart->save();
        }

        return response()->json(['redirect' => url('cart/index/' . $userId)], 200);
    }

    /**
     * Delete product from cart
     *
     * @param int $productId
     * @return void
     */
    public function delete(int $productId)
    {
        $this
            ->cartService
            ->getCartProductByUser($productId, Auth::user()->id)
            ->delete();
        
        return response()->json(
            [
                'message'=> __('messages.cart.delete_success_message'),
                'id' => $productId
            ],
            200
        );
    }
}
