<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\product;
use DB;
use Auth;

class search extends Controller
{
    public function search(Request $request){

        if($request->has('search')){

            $searchText = $request->search;
            $searchText = explode(' ', $request->search);
            $execlude = ['-','/','\\','#','$','@','!','%','+','&'];

            foreach ($searchText as $value) {

                if(!in_array($value,$execlude)){

                    $searchQ[] = product::where('name', 'LIKE', "%$value%")
                    //->orWhere('desc', 'LIKE', "%$value%")
                    ->with('productImg', 'brand')
                    ->get();
                }
            }

            // convert searchQ array from 2d to 1d to remove dublicate values
            foreach ($searchQ as $twoD) {
                foreach ($twoD as $oneD) {
                    $search[] = $oneD;
                }
            }

            if(!empty($search)){
                $search = array_unique($search);

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
                    'search' => $search,
                    'wishlists' => $wishlists,
                );

                return view('app.search.index')->with($data);
            }else{
                return view('app.search.index')->with('error', 'Sorry, No results found!');
            }

            

        }else{
            return view('app.search.index')->with('error', 'Sorry, No results found!');
        }
        
    }
}
