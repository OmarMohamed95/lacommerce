<?php

namespace App\Repositories\Contracts;

use App\Model\Category;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories
     *
     * @return Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get single category by id
     *
     * @param int $categoryId
     * @return Category
     */
    public function find(int $categoryId);

    /**
     * Get category by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     */
    public function findBy(string $column, $value);
}