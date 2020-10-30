<?php

namespace App\Filters;

use App\Contracts\FilterInterface;
use Illuminate\Database\Query\Builder;

class PriceFilter extends FilterInterface
{
    /**
     * Filter results
     *
     * @param Builder $qb
     * @param mixed $value
     * @return Builder
     */
    public function filter(Builder $qb, $value): Builder
    {
        $value = $this->fixMixAndMaxPrices($value);
        return $this->getRepository()->addPriceFilter($qb, $value);
    }

    /**
     * Replace min & max if min > max
     *
     * @param array $prices
     * @return array
     */
    private function fixMixAndMaxPrices(array $prices): array
    {
        $minPrice = $prices['min'] ?? null;
        $maxPrice = $prices['max'] ?? null;
        if ($minPrice && $maxPrice && $minPrice > $maxPrice) {
            $prices['min'] = $maxPrice;
            $prices['max'] = $minPrice;
        }
        return $prices;
    }
}