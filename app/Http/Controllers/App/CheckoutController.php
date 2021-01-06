<?php

namespace App\Http\Controllers\App;

use App\Constants\CheckoutStates;
use App\Events\CheckoutDone;
use App\Events\CheckoutOccur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Checkout;
use App\Model\Cart;
use App\Model\Product;
use App\Repositories\Contracts\CheckoutRepositoryInterface;
use App\Services\CheckoutService;
use App\Services\CartService;
use App\Services\ProductService;
use Auth;

class CheckoutController extends Controller
{
    /**
     * Checkout service
     *
     * @var CheckoutService $checkoutService
     */
    private $checkoutService;
    
    /**
     * Checkout repository
     *
     * @var CheckoutRepositoryInterface $checkoutRepository
     */
    private $checkoutRepository;
    
    /**
     * Cart service
     *
     * @var CartService $cartService
     */
    private $cartService;
    
    /**
     * Product service
     *
     * @var ProductService $productService
     */
    private $productService;

    public function __construct(
        CheckoutService $checkoutService,
        CheckoutRepositoryInterface $checkoutRepository,
        CartService $cartService,
        ProductService $productService
    ) {
        $this->middleware('auth');
        $this->checkoutService = $checkoutService;
        $this->checkoutRepository = $checkoutRepository;
        $this->cartService = $cartService;
        $this->productService = $productService;
    }

    /**
     * Checkout index
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cart = $this->cartService->getCart();

        return view('app.checkout.index')->with('cart', $cart);
    }
    
    /**
     * Checkout action
     *
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request, int $userId)
    {
        $cartQuery = $this->cartService->getCartQuery();
        $cart = $cartQuery->get();

        $orderCode = sprintf('%d%s', $userId, md5(uniqid(rand(), true)));

        foreach ($cart as $cartItem) {
            $product = $cartItem->product;

            $checkout = new Checkout;
            $checkout->product_id = $cartItem->product_id;
            $checkout->user_id = $userId;
            $checkout->quantity = $cartItem->quantity;
            if ($cartItem->quantity > $product->quantity) {
                $checkout->quantity = $product->quantity;
            }
            $checkout->address = $request->address;
            $checkout->phone = $request->phone;
            $checkout->order_code = $orderCode;
            $checkout->state = CheckoutStates::PENDING;
            $checkout->save();

            event(new CheckoutOccur($product, $cartItem->quantity));
        }
        
        event(new CheckoutDone($cartQuery));
        
        return redirect()
            ->route(
                'checkout_done',
                [
                    'orderCode' => $checkout->order_code
                ]
            );
    }

    /**
     * Checkout done
     *
     * @param string $orderCode
     * @return \Illuminate\View\View
     */
    public function done(string $orderCode)
    {
        return view('app.checkout.done')->with('orderCode', $orderCode);
    }

    /**
     * My orders
     *
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function myOrders($userId)
    {
        $orders =  $this->checkoutService->getAllCheckoutsByUser($userId);
        $groupedOrders = $this->checkoutService->groupOrdersByOrderCode($orders);

        return view('app.checkout.orders')->with('orders', $groupedOrders);
    }

    /**
     * Track order by order code
     *
     * @param string $orderCode
     * @param Request $request
     * @return View
     */
    public function trackOrderByCode(Request $request, $orderCode = null)
    {
        $trackOrderView = view('app.checkout.track_order');

        if ($request->isMethod('POST') || $orderCode) {
            $orderCode = $orderCode ?? $request->order_code;  
            $order = $this->checkoutRepository
                ->findBy('order_code', $orderCode);

            if ($order->isNotEmpty()) {
                return view('app.checkout.track')->with('order', $order);
            }

            return $trackOrderView
                ->with('msg', __('messages.checkout.invalid_order_code'));
        }

        return $trackOrderView;
    }
}
