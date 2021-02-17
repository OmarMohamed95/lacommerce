<?php

namespace App\Services;

use App\Model\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService
{
    /**
     * Category repository
     *
     * @var CategoryRepositoryInterface $categoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get categories that have products for home page
     *
     * @param int $productId
     * @return Collection
     */
    public function getCategoryWithProductsForHomePage()
    {
        return $this->categoryRepository->getCategoryWithProductsForHomePage();
    }

    /**
     * Get sub categories
     *
     * @return Collection
     */
    public function getSubCategories()
    {
        return $this->categoryRepository->getSubCategories();
    }
}