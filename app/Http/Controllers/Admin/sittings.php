<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\sitting;

class sittings extends Controller
{
    public function index(){
        $sittings = sitting::orderBy('id', 'desc')->first();
        return view('admin.sittings.index')->with('sittings', $sittings);
    }

    public function create(Request $request){

        $messages = [
            'required' => 'The :attribute is required.',
            'E-Mail' => 'The :attribute is not valid Email.',
            'URL' => 'The :attribute is not valid URL.',
        ];

        $this->validate($request, [
            'email' => 'required|E-Mail',
            'fb' => 'required|URL',
            'tw' => 'required|URL',
            'yt' => 'required|URL',
        ], $messages);

        $sittings = new sitting;
        $sittings->email = $request->email;
        $sittings->fb = $request->fb;
        $sittings->tw = $request->tw;
        $sittings->yt = $request->yt;
        $sittings->save();

        return redirect(aurl('sittings'))->with('success', 'Sittings Setted');
    }

    public function update(Request $request, $id){

        $messages = [
            'required' => 'The :attribute is required.',
        ];

        $this->validate($request, [
            'email' => 'required|E-Mail',
            'fb' => 'required|URL',
            'tw' => 'required|URL',
            'yt' => 'required|URL',
        ], $messages);

        $sittings = sitting::find($id);
        $sittings->email = $request->email;
        $sittings->fb = $request->fb;
        $sittings->tw = $request->tw;
        $sittings->yt = $request->yt;
        $sittings->save();

        return redirect(aurl('sittings'))->with('success', 'Sittings Updated');
    }
}
