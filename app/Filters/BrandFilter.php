<?php

namespace App\Filters;

use App\Contracts\FilterInterface;
use Illuminate\Database\Query\Builder;

class BrandFilter extends FilterInterface
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
        return $this->getRepository()->addBrandFilter($qb, $value);
    }
}