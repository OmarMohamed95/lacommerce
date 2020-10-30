<?php

namespace App\Contracts;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

interface SearchFilterInterface
{
    /**
     * Handle search filter
     *
     * @param int $categoryId
     * @return null|Builder
     */
    public function filter(int $categoryId);
}