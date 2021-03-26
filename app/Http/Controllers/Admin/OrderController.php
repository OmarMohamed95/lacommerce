<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\OrderService;

/**
 * Order Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class OrderController extends Controller
{
    /**
     * Order service
     *
     * @var OrderService $orderService
     */
    private $orderService;

    /**
     * @var OrderRepositoryInterface $orderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }

    /**
     * Index action
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $paginatedOrders = $this->orderRepository->getPaginatedOrders();

        return view('admin.order.index')->with('orders', $paginatedOrders);
    }

    /**
     * Overview action
     *
     * @param Order $order
     * 
     * @return \Illuminate\View\View
     */
    public function overview(Order $order)
    {
        $totalPrice = $this->orderService->calculateTotalPrice($order);

        return view('admin.order.overview')->with(
            [
                'order' => $order,
                'totalPrice' => $totalPrice,   
            ]
        );
    }

    /**
     * Update status action
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request)
    {
        $orderIds = $request->orderIds;

        if (empty($orderIds)) {
            return redirect()
                ->route('admin_order_index')
                ->with('error', 'No order was selected!');
        }

        foreach ($orderIds as $orderId) {
            $order = $this->orderRepository->find($orderId);

            if ($order) {
                $order->status = $request->multipleStatus;
                $order->save();
            }
        }

        return redirect()
            ->route('admin_order_index')
            ->with('success', 'Orders has been updated successfully.');
    }
}
