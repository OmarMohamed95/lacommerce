<?php

namespace App\Http\Controllers\app;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\checkout;
use App\adminModel\cart;
use App\adminModel\product;
use Auth;

class checkouts extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $id = Auth::user()->id;
        $cart = cart::where('user_id', $id)->get();

        return view('app.checkout.index')->with('cart', $cart);
    }
    
    public function checkout(Request $request, $id){
        $cart = cart::where('user_id', $id)->get();
        
        $order_code = Auth::user()->id . rand(999,1000000);

        foreach($cart as $c){

            $product = product::find($c->product_id);

            $checkout = new checkout;
            $checkout->product_id = $c->product_id;
            $checkout->user_id = $id;
            if($c->quantity <= $product->quantity){
                $checkout->quantity = $c->quantity;
                //update product quantity
                $product->quantity = $product->quantity - $c->quantity;
                $product->save();
            }else{
                $checkout->quantity = $product->quantity;
                //update product quantity
                $product->quantity = 0;
                $product->save();
            }
            $checkout->address = $request->address;
            $checkout->phone = $request->phone;
            $checkout->order_code = $order_code;
            $checkout->save();
            
        }
        
        $cart = cart::where('user_id', $id);
        $cart->delete();
        
        return redirect(url("checkout/done/$checkout->order_code"));
    }

    public function done($order_code){
        return view('app.checkout.done')->with('order_code' ,$order_code);
    }

    public function orders($id){
        $orders = checkout::where('user_id', $id)->get();
        //dd($orders[0]->products->productImg);
        return view('app.checkout.orders')->with('orders' ,$orders);
    }

    public function track($order_code){
        $order = checkout::where('order_code', $order_code)->get();
        return view('app.checkout.track')->with('order' ,$order);
    }

    public function track_order(){
        return view('app.checkout.track_order');
    }

    public function trackOrderByNumber(Request $request){
        $order = checkout::where('order_code', $request->order_code)
                            ->where('user_id', Auth::user()->id)
                            ->first();

        if($order){
            return redirect(url("checkout/track/$request->order_code"));
        }else{
            return redirect(url("checkout/track_order"))->with('msg', 'The order code you have entered is wrong, Please try again!');
        }
    }
}
