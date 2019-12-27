<?php

namespace App\Http\Controllers\app;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\adminModel\cart;
use App\adminModel\product;

class carts extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        $cartProducts = cart::where('user_id', $id)->get();

        /*if($cartProducts->count() > 0){

            // get total price
            foreach ($cartProducts as $item){
                foreach ($item->products as $i){
                    $p[] = $i->price;
                    $total = array_sum($p);
                }
            }

            $data = array(
                'total' => $total,
                 'cartProducts' => $cartProducts
            );

        }else{

            $data = array(
                 'cartProducts' => $cartProducts
            );
        }*/
            
        

        return view('app.cart.index')->with('cartProducts', $cartProducts);
    }

    public function updateQuantity(Request $request, $user_id, $product_id){

        $product = product::where('id', $product_id)->first();
        
        $this->validate($request, [
            'quantity' => "required|Numeric|min:1|max:$product->quantity",
        ]);

        if($request->ajax()){
            $update_quantity = cart::where('user_id', $user_id)
                                    ->where('product_id', $product_id)->first();
            $update_quantity->quantity = $request->quantity;
            $update_quantity->save();
        }
    }

    public function store($id){

        $userID = Auth::user()->id;

        $cartUpdate = cart::where('user_id', $userID)
                            ->where('product_id', $id)
                            ->first();
        $productQuantity = product::where('id', $id)->first();

        if($productQuantity->quantity === 0){
            return response()->json(array('available' => false, 'msg' => 'This product does not have more available stock.', 'cancel' => 'Continue Shopping'), 200);
        } 

        if($cartUpdate != null){
            if($cartUpdate->quantity === $productQuantity->quantity){    
                return response()->json(array('available' => false, 'msg' => 'This product does not have more available stock.', 'cancel' => 'Continue Shopping'), 200);
            }

            $cartUpdate->quantity = $cartUpdate->quantity + 1;
            $cartUpdate->save();

        }else{
   
            $cart = new cart;
            $cart->product_id = $id;
            $cart->user_id = $userID;
            $cart->save();
            
            $quantity = cart::find($cart->id);
            $quantity->quantity = $cart->quantity + 1;
            $quantity->save();
        }

        return response()->json(array('available' => true, 'redirect' => url('cart/index/' . $userID), 'msg' => 'The product has been added to your cart.', 'confirm' => 'View Cart and Checkout', 'cancel' => 'Continue Shopping'), 200);
    }

    public function delete($id){

        $user_id = Auth::user()->id;

        $deleteWishlist = cart::where('product_id', $id)
                                    ->where('user_id', $user_id);
        $deleteWishlist->delete();
        
        return response()->json(array('message'=> 'The product has been deleted', 'id' => $id), 200);

    }
}
