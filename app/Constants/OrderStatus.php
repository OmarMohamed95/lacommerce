<?php

namespace App\Constants;

final class OrderStatus
{
    const PENDING = 0;
    const PENDING_LABEL = 'Pending';
    
    const PREPARING = 1;
    const PREPARING_LABEL = 'Preparing';

    const SHIPPED = 2;
    const SHIPPED_LABEL = 'Shipped';

    const DELIVERED = 3;
    const DELIVERED_LABEL = 'Delivered';

    private static $labels = [
        self::PENDING => self::PENDING_LABEL,
        self::PREPARING => self::PREPARING_LABEL,
        self::SHIPPED => self::SHIPPED_LABEL,
        self::DELIVERED => self::DELIVERED_LABEL,
    ];

    /**
     * Get status label
     *
     * @param int $status
     * @return void
     * @throws \Exception
     */
    public static function getStatusLabel(int $status)
    {
        if (!array_key_exists($status, self::$labels)) {
            throw new \Exception(sprintf('The provided status (%d) could not be found!', $status));
        }

        return self::$labels[$status];
    }
}