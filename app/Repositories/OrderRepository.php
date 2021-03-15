<?php

namespace App\Repositories;

use App\Model\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Get all orders
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return Order::all();
    }

    /**
     * Get single order by id
     *
     * @param int $orderId
     * @return Order
     */
    public function find(int $orderId)
    {
        return Order::find($orderId);
    }

    /**
     * Get order by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return Order::where($column, $value)->get();
    }

    /**
     * Get paginated orders
     *
     * @param int $countPerPage
     * @return Illuminate\Support\Collection
     */
    public function getPaginatedOrders(int $countPerPage = 10)
    {
        return DB::table('orders')
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate($countPerPage);
    }
}