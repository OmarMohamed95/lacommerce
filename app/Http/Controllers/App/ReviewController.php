<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\ReviewRequest;
use Illuminate\Support\Facades\Auth;
use App\Model\Review;

class ReviewController extends Controller
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
        if ($request->ajax()) {
            $review = new Review();
            $review->content = $request->content;
            $review->product_id = $productId;
            $review->user_id = Auth::user()->id;
            $review->save();

            return response()->json(['review' => $review], 200);   
        }
    }
}
