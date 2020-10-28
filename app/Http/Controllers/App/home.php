<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Category;
use DB;
use Auth;

class home extends Controller
{
    public function index(){
        $offers = Product::where('offer', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $productsByCat = Category::with('products')
                                ->where('home', 1)
                                ->whereNotNull('parentID')
                                ->get();
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
            'offers' => $offers,
            'productsByCat' => $productsByCat,
            'wishlists' => $wishlists,
        );
        return view('app.home.index')->with($data);
    }
}
