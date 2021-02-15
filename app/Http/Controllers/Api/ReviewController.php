<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\App\ReviewRequest;
use Illuminate\Support\Facades\Auth;
use App\Model\Review;

class ReviewController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Review product action
     *
     * @param ReviewRequest $request
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function review(ReviewRequest $request, int $productId)
    {
        $review = new Review();
        $review->content = $request->content;
        $review->product_id = $productId;
        $review->user_id = Auth::guard('api')->user()->id;
        $review->save();

        $review->user;

        return $this->respondJson(['review' => $review]);
    }
}
