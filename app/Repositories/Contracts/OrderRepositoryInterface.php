<?php

namespace App\Repositories\Contracts;

use App\Model\Order;

interface OrderRepositoryInterface
{
    /**
     * Get all orders
     *
     * @return Order[]
     */
    public function all();

    /**
     * Get single order by id
     *
     * @param int $orderId
     * @return Order
     */
    public function find(int $orderId);

    /**
     * Get order by column
     *
     * @param string $column
     * @param mixed $value
     * @return Order
     */
    public function findBy(string $column, $value);
}