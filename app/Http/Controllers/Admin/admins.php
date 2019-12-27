<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\adminModel\Admin;
use Illuminate\Validation\Rule;

class admins extends Controller
{
    public function index()
    {
        return view('admin.login.index');
    }

    public function allAdmins()
    {
        $allAdmins = Admin::paginate(10);
        return view('admin.admins.index')->with('allAdmins', $allAdmins);
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'The :attribute is required.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|E-Mail|unique:admins',
            'password' => 'required',
        ], $messages);

        $admin = new admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect(aurl('admins/allAdmins'));
    }
    public function edit($id)
    {
        $single = admin::where('id', $id)->first();
        return view('admin.admins.edit')->with('single', $single);
    }
    public function update(Request $request, $id)
    {

        $messages = [
            'required' => 'The :attribute is required.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|E-Mail',Rule::unique('admins')->ignore($id),
            'password' => 'required',
        ], $messages);

        $admin = admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect(aurl('admins/allAdmins'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSingle($id)
    {
        //delete reviews from DB
        $delete = admin::where('id', $id);
        $delete->delete();
        return redirect(aurl('admins/allAdmins'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMultible(Request $request)
    {
        $id = $request->id;
        if(empty($id)){
            return redirect(aurl('admins/allAdmins'));
        }

        //delete reviews from DB
        $delete = admin::whereIn('id', $id);
        $delete->delete();
        return redirect(aurl('admins/allAdmins'));
    }

    public function checkLogin(Request $request)
    {
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return redirect('admin/home');
        }else{
            return redirect('admin/login');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('admin/login');
    }
}
