<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;

/**
 * User Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class UserController extends Controller
{
    /**
     * Index method
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $allAdmins = User::paginate(10);
        return view('admin.user.index')->with('allAdmins', $allAdmins);
    }
}
