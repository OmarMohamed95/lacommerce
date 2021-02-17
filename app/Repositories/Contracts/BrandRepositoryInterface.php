<?php

namespace App\Repositories\Contracts;

use App\Model\Brand;

interface BrandRepositoryInterface
{
    /**
     * Get all brands
     *
     * @return Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get single brand by id
     *
     * @param int $brandId
     * @return Brand
     */
    public function find(int $categoryId);

    /**
     * Get brand by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     */
    public function findBy(string $column, $value);
}