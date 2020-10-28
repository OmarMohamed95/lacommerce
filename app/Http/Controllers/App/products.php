<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Model\Review;

class products extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Show product
     *
     * @param int $id product ID
     * 
     * @return \Illuminate\View\View
     */
    public function index(int $id)
    {
        $product = Product::find($id);

        $review = Review::where('product_id', $id)->orderBy('id', 'desc')->get();

        $isWishlisted = false;
        if (Auth::check()) {
            $isWishlisted = Wishlist::where('user_id', Auth::user()->id)
                ->where('product_id', $id)
                ->select('product_id')
                ->first();

            if ($isWishlisted) {
                $isWishlisted = true;
            }
        }

        $data = array(
            'product' => $product,
            'review' => $review,
            'isWishlisted' => $isWishlisted,
        );

        return view('app.product.index')->with($data);
    }

    public function review(Request $request, $productID){
        if($request->ajax()){

            $rules = [
                'content' => 'required'
            ];

            $messages = [
                'required' => 'Review input is required'
            ];

            $validate = $this->validate($request, $rules, $messages);

            $review = new Review;
            $review->content = $request->content;
            $review->product_id = $productID;
            $review->user_id = Auth::user()->id;
            $review->save();

            $review = Review::with('user')->where('product_id', $productID)->orderBy('id', 'desc')->first();

            return response()->json(array('review'=> $review), 200);   
        }
        //return view('app.product.index');
    }
}
