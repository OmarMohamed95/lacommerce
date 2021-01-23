<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use App\Services\WishlistService;

class WishlistController extends Controller
{
    /**
     * @var WishlistRepositoryInterface $wishlistRepository
     */
    private $wishlistRepository;

    /**
     * @var WishlistService
     */
    private $wishlistService;

    /**
     * @param WishlistRepositoryInterface $wishlistRepository
     * @param WishlistService $wishlistService
     */
    public function __construct(
        WishlistRepositoryInterface $wishlistRepository,
        WishlistService $wishlistService
    ) {
        $this->wishlistRepository = $wishlistRepository;
        $this->wishlistService = $wishlistService;
        $this->middleware('auth');
    }

    /**
     * Index action
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $wishlist = $this->wishlistRepository->findBy('user_id', Auth::user()->id);

        return view('app.wishlist.index')->with('wishlist', $wishlist);
    }

    /**
     * Store action
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $productId)
    {
        $isWishlisted = $this->wishlistService->isWishlisted($productId);

        if ($isWishlisted) {
            return response()
                ->json(
                    [
                        'message' => __('messages.wishlist.product_already_exist')
                    ],
                    200
                );
        }

        $this->wishlistService->addToWishlist($productId);
        
        return response()
            ->json(
                [
                    'message' => __('messages.wishlist.product_added_successfully')
                ],
                200
            );

    }

    /**
     * Delete product from wishlist
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $productId)
    {
        $this->wishlistService->removeFromWishlist($productId);
        
        return response()
            ->json(
                [
                    'message' => __('messages.wishlist.product_removed'),
                    'id' => $productId
                ],
                200
            );
    }

}
