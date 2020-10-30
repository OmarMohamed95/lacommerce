<?php

namespace App\Http\Controllers\App;

use App\Contracts\SearchFilterInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CategoryBrand;
use App\Model\Category;
use App\Model\CustomFieldCategory;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\ProductService;
use App\Services\CustomFieldService;
use App\Services\WishlistService;
use DB;
use Auth;
use Illuminate\Database\Query\Builder;

class CategoryController extends Controller
{
    const ITEMS_PER_PAGE = 3;

    /**
     * Category repository
     *
     * @var CategoryRepositoryInterface $categoryRepository
     */
    private $categoryRepository;
    
    /**
     * Product service
     *
     * @var ProductService $productService
     */
    private $productService;
    
    /**
     * CustomField service
     *
     * @var CustomFieldService $customFieldService
     */
    private $customFieldService;
    
    /**
     * Wishlist service
     *
     * @var WishlistService $wishlistService
     */
    private $wishlistService;
    
    /**
     * Search filter service
     *
     * @var SearchFilterInterface $searchFilter
     */
    private $searchFilter;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        ProductService $productService,
        CustomFieldService $customFieldService,
        WishlistService $wishlistService,
        SearchFilterInterface $searchFilter
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productService = $productService;
        $this->customFieldService = $customFieldService;
        $this->wishlistService = $wishlistService;
        $this->searchFilter = $searchFilter;
    }

    /**
     * Category index
     *
     * @param int $categoryId
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request, int $categoryId)
    {
        if ($request->all()) {
            $results = $this->searchFilter->filter($categoryId);
        }
        
        $products = isset($results) && $results ?
            $results : 
            $this
                ->productService
                ->getProductsByCategory($categoryId);

        $products = $products->paginate(self::ITEMS_PER_PAGE);

        $customFields = $this
            ->customFieldService
            ->getCustomFieldsByCategory($categoryId);

        $category = $this->categoryRepository->find($categoryId);

        if (Auth::check()) {
            $wishlistProductsIds = $this
                ->wishlistService
                ->getWishlistProductsIds();
        }   
        
        return view('app.category.index')->with(
            [
                'products' => $products,
                'category' => $category,
                'customFields' => $customFields,
                'wishlistProductsIds' => $wishlistProductsIds ?? [],
            ]
        );
    }
}
