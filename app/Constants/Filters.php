<?php

namespace App\Constants;

final class Filters
{
    const PRICE = 'price';
    const BRAND = 'brand';
    const SORT_BY = 'sort_by';
    const CUSTOM_FIELD = 'custom_field';

    public static function getFilters()
    {
        return [
            self::PRICE,
            self::BRAND,
            self::SORT_BY,
            self::CUSTOM_FIELD,
        ];
    }
}