<?php

namespace App\Http\Controllers\App;

use App\Constants\OrderStatus;
use App\Events\OrderDone;
use App\Events\OrderOccur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Cart;
use App\Model\OrderProduct;
use App\Model\Product;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\OrderService;
use App\Services\CartService;
use App\Services\ProductService;
use Auth;

class OrderController extends Controller
{
    /**
     * Order service
     *
     * @var OrderService $orderService
     */
    private $orderService;
    
    /**
     * Order repository
     *
     * @var OrderRepositoryInterface $orderRepository
     */
    private $orderRepository;
    
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
        OrderService $orderService,
        OrderRepositoryInterface $orderRepository,
        CartService $cartService,
        ProductService $productService
    ) {
        $this->middleware('auth');
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
        $this->cartService = $cartService;
        $this->productService = $productService;
    }

    /**
     * Order index
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cart = $this->cartService->getCart();

        if ($cart->isEmpty()) {
            return redirect()->route('cart_index');
        }

        return view('app.order.index')->with('cart', $cart);
    }
    
    /**
     * Checkout action
     *
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request)
    {
        $cartQuery = $this->cartService->getCartQuery();
        $cart = $cartQuery->get();

        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->status = OrderStatus::PENDING;
        $order->save();

        foreach ($cart as $cartItem) {
            $product = $cartItem->product;

            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $cartItem->product_id;
            $orderProduct->quantity = $cartItem->quantity;
            if ($cartItem->quantity > $product->quantity) {
                $orderProduct->quantity = $product->quantity;
            }
            $orderProduct->price = $cartItem->product->price;
            $orderProduct->save();

            event(new OrderOccur($product, $cartItem->quantity));
        }
        
        event(new OrderDone($cartQuery));
        
        return redirect()
            ->route(
                'order_done',
                [
                    'orderCode' => $order->id
                ]
            );
    }

    /**
     * Order done
     *
     * @param string $orderCode
     * @return \Illuminate\View\View
     */
    public function done(string $orderId)
    {
        return view('app.order.done')->with('orderId', $orderId);
    }

    /**
     * My orders
     *
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function myOrders($userId)
    {
        $orders =  $this->orderService->getAllOrdersByUser($userId);

        return view('app.order.orders')->with('orders', $orders);
    }

    /**
     * Track order by order code
     *
     * @param string $orderCode
     * @param Request $request
     * @return View
     */
    public function trackOrderByCode(Request $request, $orderId = null)
    {
        $trackOrderView = view('app.order.track_order');

        if ($request->isMethod('POST') || $orderId) {
            $orderId = $orderId ?? $request->orderId;

            $order = $this->orderRepository->find($orderId);

            if ($order) {
                $totalPrice = $this->orderService->calculateTotalPrice($order);

                return view('app.order.track')->with(
                    [
                        'order' => $order,
                        'totalPrice' => $totalPrice,
                    ]
                );
            }

            return $trackOrderView
                ->with('msg', __('messages.order.invalid_order_id'));
        }

        return $trackOrderView;
    }
}
