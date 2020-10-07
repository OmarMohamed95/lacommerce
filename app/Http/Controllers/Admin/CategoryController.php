<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\adminModel\category;
use DB;
use App\Http\Requests\CategoryRequest;

/**
 * Categories Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCategories = category::paginate(10);
        return view('admin.categories.index')->with('allCategories', $allCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allCategories = DB::select("SELECT * FROM categories where parentID is NULL");

        return view('admin.categories.create')->with('allCategores', $allCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\CategoryRequest $request 
     * 
     * @return Redirect
     */
    public function store(CategoryRequest $request)
    {
        $category = new category;
        $category->name = $request->name;

        if ($request->parentID === 'FALSE') {
            $category->parentID = null;
        } else {
            $category->parentID = $request->parentID;
        }
        
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
     * @param int $id Category id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allCategories = DB::select("SELECT * FROM categories where parentID is NULL");
        $single = category::where('id', $id)->first();
        $data = [
            'allCat' => $allCategories,
            'single' => $single
        ];
        
        return view('admin.categories.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\CategoryRequest $request 
     * @param int $id Category id
     * 
     * @return Redirect
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = category::find($id);
        $category->name = $request->name;

        if ($request->parentID === 'FALSE') {
            $category->parentID = null;
        } else {
            $category->parentID = $request->parentID;
        }

        $category->status = $request->status;
        $category->sort = $request->sort;
        $category->home = $request->home;
        $category->admin_id = Auth::guard('admin')->user()->id;
        $category->save();

        return redirect(aurl('categories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id Category id
     * 
     * @return Redirect
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
     * @param \Illuminate\Http\Request $request 
     * 
     * @return Redirect
     */
    public function deleteMultible(Request $request)
    {
        $id = $request->id;

        if (empty($id)) {
            return redirect(aurl('categories'));
        }

        $delete = category::whereIn('id', $id);
        $delete->delete();
        return redirect(aurl('categories'));
    }
}
