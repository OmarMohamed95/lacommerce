<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Cart;
use App\Model\Product;
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
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function index(int $userId)
    {
        $cartProducts = $this->cartRepository->findBy('user_id', $userId);
        $totalPrice = $this->cartService->getTotalCartPrice($userId);
        return view('app.cart.index')
            ->with(
                [
                    'cartProducts' => $cartProducts,
                    'totalPrice' => $totalPrice,
                ]
            );
    }
}
