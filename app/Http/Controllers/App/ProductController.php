<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\ProductService;
use App\Services\ReviewService;
use App\Services\WishlistService;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface $productRepository
     */
    private $productRepository;
    
    /**
     * @var ProductService $productService
     */
    private $productService;
    
    /**
     * @var ReviewService $reviewService
     */
    private $reviewService;
    
    /**
     * @var WishlistService $wishlistService
     */
    private $wishlistService;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductService $productService,
        ReviewService $reviewService,
        WishlistService $wishlistService
    ) {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->reviewService = $reviewService;
        $this->wishlistService = $wishlistService;
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Show product details
     *
     * @param int $productId
     * @return \Illuminate\View\View
     */
    public function index(int $productId)
    {
        $product = $this->productRepository->find($productId);

        $reviews = $this->reviewService->getReviewForProductPage($productId);

        if (Auth::check()) {
            $isWishlisted = $this->wishlistService->isWishlisted($productId);
        }

        return view('app.product.index')->with(
            [
                'product' => $product,
                'reviews' => $reviews,
                'isWishlisted' => $isWishlisted,
            ]
        );
    }
}
