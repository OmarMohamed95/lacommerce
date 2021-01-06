<?php

namespace App\Services;

use App\Model\Checkout;
use App\Repositories\Contracts\CheckoutRepositoryInterface;
use Illuminate\Support\Collection;

class CheckoutService
{
    /**
     * Checkout Repository
     *
     * @var CheckoutRepositoryInterface $checkoutRepository
     */
    private $checkoutRepository;

    public function __construct(CheckoutRepositoryInterface $checkoutRepository)
    {
        $this->checkoutRepository = $checkoutRepository;
    }

    /**
     * Get all checkouts by user
     *
     * @param int $userId
     * @return Collection
     */
    public function getAllCheckoutsByUser(int $userId)
    {
        return $this->checkoutRepository->findBy('user_id', $userId);
    }

    /**
     * Group orders by order code
     *
     * @param Collection $orders
     * @return array
     */
    public function groupOrdersByOrderCode(Collection $orders)
    {
        $groupedOrders = [];
        foreach ($orders as $orderkey => $order) {
            $prevOrderKey = $orderkey - 1;
            if ($orderkey == 0 || $orders[$prevOrderKey]->order_code != $order->order_code) {
                $groupedOrders[$order->order_code][] = $order;
            } else {
                $groupedOrders[$orders[$prevOrderKey]->order_code][] = $order;
            }
        }

        return $groupedOrders;
    }
}