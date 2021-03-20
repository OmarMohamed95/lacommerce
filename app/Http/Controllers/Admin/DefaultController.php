<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Default Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * Index method
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.home.index');
    }
}
