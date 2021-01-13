<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Category;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\WishlistService;
use DB;
use Auth;

class DefaultController extends Controller
{
    /**
     * @var ProductService $productService
     */
    private $productService;
    
    /**
     * @var CategoryService $categoryService
     */
    private $categoryService;
    
    /**
     * @var WishlistService $wishlistService
     */
    private $wishlistService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        WishlistService $wishlistService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->wishlistService = $wishlistService;
    }

    /**
     * Home page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $offers = $this->productService->getOfferProductsForHomePage();
        
        $homeCategoryProducts = $this->categoryService
            ->getCategoryWithProductsForHomePage();

        if (Auth::check()) {
            $wishlistProducts = $this->wishlistService->getWishlistProductsIds();
        }
            
        $data = [
            'offers' => $offers,
            'homeCategoryProducts' => $homeCategoryProducts,
            'wishlistProducts' => $wishlistProducts ?? [],
        ];

        return view('app.home.index')->with($data);
    }
}
