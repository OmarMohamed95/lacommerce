<?php

namespace App\Factory;

use App\Constants\Filters;
use App\Contracts\FilterInterface;
use App\Filters\BrandFilter;
use App\Filters\CustomFieldFilter;
use App\Filters\PriceFilter;
use App\Filters\SortByFilter;

class FilterFactory
{
    /**
     * Filter factory
     *
     * @param string $filter
     * @return FilterInterface
     */
    public function create(string $filter): FilterInterface
    {
        switch ($filter) {
        case Filters::PRICE:
            return new PriceFilter();
            break;
        case Filters::BRAND:
            return new BrandFilter();
            break;
        case Filters::SORT_BY:
            return new SortByFilter();
            break;
        case Filters::CUSTOM_FIELD:
            return new CustomFieldFilter();
            break;
        }
    }
}