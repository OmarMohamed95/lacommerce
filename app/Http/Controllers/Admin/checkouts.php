<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\checkout;

/**
 * Checkouts Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class checkouts extends Controller
{
    /**
     * Index method
     * 
     * @return Response
     */
    public function index()
    {

        $all = checkout::orderBy('created_at', 'asc')->paginate(10);

        return view('admin.checkout.index')->with('all', $all);
    }

    /**
     * Overview method
     *
     * @param int $orderCode 
     * 
     * @return Response
     */
    public function overview($orderCode)
    {
        $single = checkout::where('order_code', $orderCode)->get();

        return view('admin.checkout.overview')->with('single', $single);
    }

    /**
     * State multible method
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return Redirect
     */
    public function state_multible(Request $request)
    {
        $orderCode = $request->order_code;

        if (empty($orderCode)) {
            return redirect(aurl('checkout'));
        }
        
        foreach ($orderCode as $v) {
            $checkouts = checkout::where('order_code', $v)->get();

            foreach ($checkouts as $checkout) {
                $checkout->state = $request->state_button;
                $checkout->save();
            }

        }

        return redirect(aurl('checkout'));
    }

    /**
     * State single method
     *
     * @param \Illuminate\Http\Request $request 
     * @param int $orderCode 
     * 
     * @return Redirect
     */
    public function state_single(Request $request, $orderCode)
    {
        
        $checkouts = checkout::where('order_code', $orderCode)->get();
        foreach ($checkouts as $checkout) {
            $checkout->state = $request->state;
            $checkout->save();
        }

        return redirect(aurl('checkout'));
    }
}
