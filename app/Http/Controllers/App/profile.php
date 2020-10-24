<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use Auth;

class profile extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $userID = Auth::user()->id;

        $user = User::where('id', $userID)->first();

        return view('app.profile.index')->with('user', $user);
    }

    public function update(Request $request){

        $userID = Auth::user()->id;

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',Rule::unique('users')->ignore($userID),
            'password' => 'required|string|min:6',
        ]);


        $user = User::where('id', $userID)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect(url('profile'));
    }
}
