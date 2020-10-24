<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\product;
use App\adminModel\brand;
use App\adminModel\categoryBrand;
use App\adminModel\category;
use App\adminModel\customFieldCategory;
use DB;
use Auth;

class categories extends Controller
{
    public function index($id){

        //$all = DB::table('products AS t')
        //                ->join('product_imgs AS i', 't.id', '=', 'i.product_id')
        //                ->join('brands AS b', 't.brand_id', '=', 'b.id')
        //                ->where('t.category_id', $id)
        //                ->select('t.*', 'b.name AS brand_name', 'i.img')
        //                ->get();
                        //->unique('id');

        $all = DB::table('products AS t')
                        ->join('brands AS b', 't.brand_id', '=', 'b.id')
                        ->select('t.*',DB::raw('(select img from product_imgs where product_id  = t.id limit 1) AS img'), 'b.name AS brand_name')
                        ->where('t.category_id', $id)
                        ->paginate(3);

        $cf = customFieldCategory::with(['custom_field' => function ($query) {
                                        $query->where('show_in_filter', '=', 1);
                                    }])
                                    ->where('category_id', $id)
                                    ->get();
        //dd($cf[2]->custom_field);
        $cat_brand = category::where('id', $id)->get()->first();

        $brands = categoryBrand::where('category_id', $id)->get();

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
            'all' => $all,
            'brands' => $brands,
            'cat_brand' => $cat_brand,
            'cf' => $cf,
            'wishlists' => $wishlists,
        );
        
        return view('app.category.index')->with($data);
    }

    public function tools(Request $request, $id){

       $cf = $request->cf; 

        $all = DB::table('products AS t');

        if($cf){
            foreach ($cf as $k => $v) {
                if($v){
                    $all = $all->join("custom_field_products AS j$k", function ($join) use($k,$v){
                        $join->on('t.id', '=', "j$k.product_id")
                            ->where("j$k.value", '=', $v);
                    });
                }
            }
        }

        $all = $all->join('brands AS b', 't.brand_id', '=', 'b.id')
                    ->select('t.*', 'b.name AS brand_name', DB::raw('(select img from product_imgs where product_id  = t.id limit 1) AS img'));

        if(isset($request->brand)){

            $brand = $request->brand;

            $all = $all->where('t.brand_id', $brand);
            
        }
        if (isset($request->max) or isset($request->min)){

            if($request->max > $request->min){

                $max = $request->max;
                $min = $request->min;

                $all = $all->whereBetween('t.price', [$min, $max]);

            }else{
                return redirect("/category/$id")->with('error', 'min is greater than max');
            }       
        }       
        if (isset($request->sortBy)) {
            
            $sort = explode('/', $request->sortBy);

            $all = $all->orderBy($sort[0], $sort[1]);

        }       

        $all = $all->where('t.category_id', $id)
                    ->paginate(3);

        $cf = customFieldCategory::where('category_id', $id)->get();

        $cat_brand = category::where('id', $id)->get()->first();

        $brands = categoryBrand::where('category_id', $id)->get();

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
            'all' => $all,
            'brands' => $brands,
            'cat_brand' => $cat_brand,
            'cf' => $cf,
            'wishlists' => $wishlists,
        );
        
        return view('app.category.index')->with($data);
    }
}
