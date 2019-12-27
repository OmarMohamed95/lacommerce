<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\adminModel\category;
use DB;

class categories extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCate = category::paginate(10);
        return view('admin.categories.index')->with('allCategories', $allCate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allCategores = DB::select("SELECT * FROM categories where parentID is NULL");

        return view('admin.categories.create')->with('allCategores', $allCategores);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'parentID' => 'required',
            'status' => 'required',
            'sort' => 'required|numeric',
            'home' => 'required',
            ]);

        $category = new category;
        $category->name = $request->name;

        if($request->parentID === 'FALSE')
        $category->parentID = NULL;
        else
        $category->parentID = $request->parentID;
        
        $category->status = $request->status;
        $category->sort = $request->sort;
        $category->home = $request->home;
        $category->admin_id = Auth::guard('admin')->user()->id;
        $category->save();

        return redirect(aurl('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allCat = DB::select("SELECT * FROM categories where parentID is NULL");
        $single = category::where('id', $id)->first();
        $data = array('allCat' => $allCat,
                      'single' => $single);
        return view('admin.categories.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'parentID' => 'required',
            'status' => 'required',
            'sort' => 'required|numeric',
            'home' => 'required',
            ]);

        $update = category::find($id);
        $update->name = $request->name;

        if($request->parentID === 'FALSE')
        $update->parentID = NULL;
        else
        $update->parentID = $request->parentID;

        $update->status = $request->status;
        $update->sort = $request->sort;
        $update->home = $request->home;
        $update->admin_id = Auth::guard('admin')->user()->id;
        $update->save();

        return redirect(aurl('categories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSingle($id)
    {
        $delete = category::where('id', $id);
        $delete->delete();
        return redirect(aurl('categories'));
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
            return redirect(aurl('categories'));
        }
        $delete = category::whereIn('id', $id);
        $delete->delete();
        return redirect(aurl('categories'));
    }
}
