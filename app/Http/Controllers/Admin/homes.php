<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Home Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class homes extends Controller
{
    /**
     * Index method.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home.index');
    }
}
