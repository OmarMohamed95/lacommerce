<?php

namespace App\Filters;

use App\Contracts\FilterInterface;
use Illuminate\Database\Query\Builder;

class SortByFilter extends FilterInterface
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
        $value = explode('/', $value);
        return $this->getRepository()->addSortByFilter($qb, $value);
    }
}