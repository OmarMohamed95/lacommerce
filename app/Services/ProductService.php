<?php

namespace App\Services;

use App\Model\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{
    /**
     * Product repository
     *
     * @var productRepositoryInterface $productRepository
     */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get products by category
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getProductsByCategory(int $categoryId)
    {
        return $this->productRepository->getProductsByCategoryQuery($categoryId);
    }

    /**
     * Get product by ID
     *
     * @param int $productId
     * @return Product
     */
    public function getProductById(int $productId)
    {
        return $this->productRepository->find($productId);
    }
}