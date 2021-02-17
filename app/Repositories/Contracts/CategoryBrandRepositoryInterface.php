<?php

namespace App\Repositories\Contracts;

interface CategoryBrandRepositoryInterface
{
    /**
     * Get all CategoryBrands
     *
     * @return Illuminate\Support\Collection
     */
    public function all();

    
    /**
     * Get CategoryBrand by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     */
    public function findBy(string $column, $value);
}