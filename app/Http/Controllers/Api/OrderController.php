<?php

namespace App\Http\Controllers\Api;

use App\Model\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    /**
     * @var OrderRepositoryInterface $orderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Update status for single order
     *
     * @param \Illuminate\Http\Request $request 
     * @param Order $order
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        return $this->respondNoContent();
    }
}
