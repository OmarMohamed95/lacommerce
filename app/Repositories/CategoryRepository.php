<?php

namespace App\Repositories;

use App\Model\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get all categories
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return Category::all();
    }

    /**
     * Get single category by id
     *
     * @param int $categoryId
     * @return Category
     */
    public function find(int $categoryId)
    {
        return Category::find($categoryId);
    }

    /**
     * Get category by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return Category::where($column, $value)->get();
    }

    /**
     * Get categories that have products for home page
     *
     * @return Collection
     */
    public function getCategoryWithProductsForHomePage()
    {
        return Category::with('products')
            ->where('home', 1)
            ->whereNotNull('parentID')
            ->get();
    }

    /**
     * Get sub categories
     *
     * @return Collection
     */
    public function getSubCategories()
    {
        return Category::whereNotNull('parentID')
        ->where('status', true)
        ->get();
    }
}