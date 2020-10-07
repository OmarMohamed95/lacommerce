<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\adminModel\Admin;
use Illuminate\Validation\Rule;
use App\Http\Requests\AdminRequest;
/**
 * Admins Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class AdminController extends Controller
{
    /**
     * Index method
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.login.index');
    }

    /**
     * AllAdmins method
     *
     * @return \Illuminate\Http\Response
     */
    public function allAdmins()
    {
        $allAdmins = Admin::paginate(10);
        return view('admin.admins.index')->with('allAdmins', $allAdmins);
    }

    /**
     * Create method
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store method
     * 
     * @param App\Http\Requests\AdminRequest $request 
     *
     * @return Redirect
     */
    public function store(AdminRequest $request)
    {
        $admin = new admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect(aurl('admins/allAdmins'));
    }

    /**
     * Edit method
     * 
     * @param int $id Admin id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $single = admin::where('id', $id)->first();
        return view('admin.admins.edit')->with('single', $single);
    }

    /**
     * Update method
     * 
     * @param \Illuminate\Http\Request $request 
     * @param int $id Brand id
     *
     * @return Redirect
     */
    public function update(AdminRequest $request, $id)
    {
        $admin = admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect(aurl('admins/allAdmins'));
    }

    /**
     * Delete single admin
     *
     * @param int $id Admin id
     * 
     * @return Redirect
     */
    public function deleteSingle($id)
    {
        //delete reviews from DB
        $delete = admin::where('id', $id);
        $delete->delete();
        return redirect(aurl('admins/allAdmins'));
    }

    /**
     * Delete multiple admins
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return Redirect
     */
    public function deleteMultible(Request $request)
    {
        $id = $request->id;
        if (empty($id)) {
            return redirect(aurl('admins/allAdmins'));
        }

        //delete reviews from DB
        $delete = admin::whereIn('id', $id);
        $delete->delete();
        return redirect(aurl('admins/allAdmins'));
    }

    /**
     * Check login
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return Redirect
     */
    public function checkLogin(Request $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('admin/home');
        } else {
            return redirect('admin/login');
        }
    }

    /**
     * Logout method
     *
     * @return Redirect
     */
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('admin/login');
    }
}
