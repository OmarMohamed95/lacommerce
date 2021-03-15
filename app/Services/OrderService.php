<?php

namespace App\Services;

use App\Model\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Collection;

class OrderService
{
    /**
     * Order Repository
     *
     * @var OrderRepositoryInterface $orderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Get all orders by user
     *
     * @param int $userId
     * @return Collection
     */
    public function getAllOrdersByUser(int $userId)
    {
        return $this->orderRepository->findBy('user_id', $userId);
    }

    /**
     * Group orders by order code
     *
     * @param Collection $orders
     * @return array
     */
    public function groupOrdersById(Collection $orders)
    {
        $groupedOrders = [];
        foreach ($orders as $orderkey => $order) {
            $prevOrderKey = $orderkey - 1;
            if ($orderkey == 0 || $orders[$prevOrderKey]->id != $order->id) {
                $groupedOrders[$order->id][] = $order;
            } else {
                $groupedOrders[$orders[$prevOrderKey]->id][] = $order;
            }
        }

        return $groupedOrders;
    }

    /**
     * Calculate total price
     *
     * @param Order $order
     * @return int
     */
    public function calculateTotalPrice(Order $order): int
    {
        $orderPrice = 0;
        foreach ($order->products as $orderProduct) {
            $orderPrice += $orderProduct->quantity * $orderProduct->price;
        }

        return $orderPrice;
    }
}