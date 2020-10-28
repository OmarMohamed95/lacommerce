<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Model\Setting;

/**
 * Settings Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class SettingController extends Controller
{
    /**
     * Index mthod
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sittings = Setting::orderBy('id', 'desc')->first();
        return view('admin.sittings.index')->with('sittings', $sittings);
    }

    /**
     * Create mthod
     *
     * @param SettingRequest $request 
     * 
     * @return Redirect
     */
    public function create(SettingRequest $request)
    {
        $sittings = new Setting;
        $sittings->email = $request->email;
        $sittings->fb = $request->fb;
        $sittings->tw = $request->tw;
        $sittings->yt = $request->yt;
        $sittings->save();

        return redirect(aurl('sittings'))->with('success', 'Sittings Setted');
    }

    /**
     * Update mthod
     *
     * @param SettingRequest $request 
     * @param int $id 
     * 
     * @return Redirect
     */
    public function update(SettingRequest $request, $id)
    {
        $sittings = Setting::find($id);
        $sittings->email = $request->email;
        $sittings->fb = $request->fb;
        $sittings->tw = $request->tw;
        $sittings->yt = $request->yt;
        $sittings->save();

        return redirect(aurl('sittings'))->with('success', 'Sittings Updated');
    }
}
