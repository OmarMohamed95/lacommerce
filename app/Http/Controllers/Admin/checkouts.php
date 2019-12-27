<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\checkout;

class checkouts extends Controller
{
    public function index(){

        $all = checkout::orderBy('created_at', 'asc')->paginate(10);

        return view('admin.checkout.index')->with('all', $all);
    }

    public function overview($order_code){

        $single = checkout::where('order_code', $order_code)->get();
        //dd($single);

        return view('admin.checkout.overview')->with('single', $single);
    }

    public function state_multible(Request $request){

        $order_code = $request->order_code;

        if(empty($order_code)){
            return redirect(aurl('checkout'));
        }
        
        foreach ($order_code as $v) {
            $update = checkout::where('order_code', $v)->get();

            foreach ($update as $u) {
                $u->state = $request->state_button;
                $u->save();
            }

        }

        return redirect(aurl('checkout'));
    }

    public function state_single(Request $request, $order_code){
        
        $update = checkout::where('order_code', $order_code)->get();
        foreach ($update as $u) {
            $u->state = $request->state;
            $u->save();
        }

        return redirect(aurl('checkout'));
    }
}
