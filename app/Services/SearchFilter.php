<?php

namespace App\Services;

use App\Constants\Filters;
use App\Contracts\SearchFilterInterface;
use App\Factory\FilterFactory;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class SearchFilter implements SearchFilterInterface
{
    /**
     * Request
     *
     * @var Request $request
     */
    private $request;
    
    /**
     * Filter factory
     *
     * @var FilterFactory $filterFactory
     */
    private $filterFactory;
    
    /**
     * Product repository
     *
     * @var ProductRepositoryInterface $productRepository
     */
    private $productRepository;
    
    /**
     * Filters
     *
     * @var array $filters
     */
    private $filters = [];

    public function __construct(
        Request $request,
        FilterFactory $filterFactory,
        ProductRepositoryInterface $productRepository
    ) {
        $this->request = $request;
        $this->filterFactory = $filterFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * Handle search filter
     *
     * @param int $categoryId
     * @return null|Builder
     */
    public function filter(int $categoryId)
    {
        if (!$this->isFiltered()) {
            return;
        }

        $qb = $this->productRepository->getProductsByCategoryQuery($categoryId);

        foreach ($this->filters as $filterName => $value) {
            $filter = $this->filterFactory->create($filterName);
            $qb = $filter->filter($qb, $value);
        }
        return $qb;
    }

    /**
     * Check if the results has filtered
     *
     * @return bool
     */
    private function isFiltered(): bool
    {
        foreach ($this->request->all() as $key => $value) {
            if (is_array($value)) {
                $value = array_filter($value);
            }

            if ($value && in_array($key, Filters::getFilters())) {
                $this->addToFiltersArray($key, $value);
            }
        }

        if ($this->filters) {
            return true;
        }
        return false;
    }

    /**
     * Add to filters array
     *
     * @param string $filter
     * @param mixed $value
     * @return void
     */
    private function addToFiltersArray(string $filter, $value): void
    {
        $this->filters[$filter] = $value;
    }
}