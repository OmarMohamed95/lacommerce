<?php

namespace App\Repositories;

use App\Model\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    /**
     * Get all brands
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return Brand::all();
    }

    /**
     * Get single brand by id
     *
     * @param int $brandId
     * @return Brand
     */
    public function find(int $categoryId)
    {
        return Brand::find($categoryId);
    }

    /**
     * Get brand by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return Brand::where($column, $value)->get();
    }

    /**
     * Get all paginated
     *
     * @param int $countPerPage
     * @return Collection
     */
    public function getAllPaginated(int $countPerPage)
    {
        return Brand::paginate($countPerPage);
    }

    /**
     * Get Brands by brandIds query
     *
     * @param array $brandIds
     * @return Builder
     */
    public function getBrandsQuery(array $brandIds)
    {
        return Brand::whereIn('id', $brandIds);
    }
}