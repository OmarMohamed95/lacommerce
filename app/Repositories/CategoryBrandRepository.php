<?php

namespace App\Repositories;

use App\Model\CategoryBrand;
use App\Repositories\Contracts\CategoryBrandRepositoryInterface;

class CategoryBrandRepository implements CategoryBrandRepositoryInterface
{
    /**
     * Get all CategoryBrand
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return CategoryBrand::all();
    }

    /**
     * Get CategoryBrand by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return CategoryBrand::where($column, $value)->get();
    }

    /**
     * Get CategoryBrand by brand query
     *
     * @param array $brandIds
     * @return Builder
     */
    public function findByBrandQuery(array $brandIds)
    {
        return CategoryBrand::whereIn('brand_id', $brandIds);
    }
}