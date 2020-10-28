<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Wishlist;

class wishlists extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){

        $wishlist = Wishlist::where('user_id', $id)->get();
        return view('app.wishlist.index')->with('wishlist', $wishlist);

    }

    public function store($id){

        $user_id = Auth::user()->id;

        $getWishlist = Wishlist::where('product_id', $id)
                                    ->where('user_id', $user_id)
                                    ->get();

        if($getWishlist->count() > 0){
            return response()->json(array('message'=> 'The product is already in your wishlist'), 200);
        }
        $wishlist = new Wishlist;
        $wishlist->product_id = $id;
        $wishlist->user_id = $user_id;
        $wishlist->save();
        
        return response()->json(array('message'=> 'The product has been added to your wishlist'), 200);

    }

    public function delete($id){

        $user_id = Auth::user()->id;

        $deleteWishlist = Wishlist::where('product_id', $id)
                                    ->where('user_id', $user_id);
        $deleteWishlist->delete();
        
        return response()->json(array('message'=> 'The product has been deleted', 'id' => $id), 200);

    }

}
