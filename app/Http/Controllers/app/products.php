<?php

namespace App\Http\Controllers\app;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\product;
use Illuminate\Support\Facades\Auth;
use App\adminModel\review;
use DB;

class products extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($id){
        $product = product::find($id);

        $review = review::where('product_id', $id)->orderBy('id', 'desc')->get();

        if(Auth::check()){
            $wishlist = DB::table('wishlists')
                                    ->where('user_id', Auth::user()->id)
                                    ->select('product_id')
                                    ->get();

            if($wishlist->count() > 0){
                foreach ($wishlist as $value) {
                    $wishlists[] = $value->product_id;
                }
            }else{
                $wishlists = [];
            }
        }else{
            $wishlists = [];
        }    

        $data = array(
            'product' => $product,
            'review' => $review,
            'wishlists' => $wishlists,
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

            $review = new review;
            $review->content = $request->content;
            $review->product_id = $productID;
            $review->user_id = Auth::user()->id;
            $review->save();

            $review = review::with('user')->where('product_id', $productID)->orderBy('id', 'desc')->first();

            return response()->json(array('review'=> $review), 200);   
        }
        //return view('app.product.index');
    }
}
