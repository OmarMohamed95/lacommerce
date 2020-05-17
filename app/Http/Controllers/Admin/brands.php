<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\brand;
use App\adminModel\category;
use App\adminModel\categoryBrand;
use Illuminate\Support\Facades\Storage;

class brands extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allBrands = brand::paginate(10);
        return view('admin.brands.index')->with('allBrands', $allBrands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allcategories = category::all();
        $parents = category::whereNotNull('parentID')->get();
        foreach ($parents as $item){
            $parentID[] = $item->parentID; 
        }
    
        $data = array(
            'allcategories' => $allcategories,
            'parentID' => $parentID ?? [],
        );
        return view('admin.brands.create')->with($data);
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
            'img' => 'image|nullable|max:2048',
            'name' => 'required',
            'category_id' => 'required',
            ]);

        if($request->hasFile('img')){
            $allowedExt = array('png','jpg', 'jpe', 'jpeg');
            $fullName = $request->file('img')->getClientOriginalName();
            $name = pathinfo($fullName, PATHINFO_FILENAME);
            $ext = $request->file('img')->getClientOriginalExtension();
            if(in_array($ext, $allowedExt)){
                $finalName = $name . '-' . time() . '.' .  $ext;
                $storePath = 'brandImg/';
                $request->file('img')->storePubliclyAs($storePath, $finalName, 'uploads');
            }else{
                return redirect(aurl("brands/$id/edit"))->with('error', 'The ext is not allowed');
            } 
        }else{
            $finalName = 'no-image-available.jpg';
        }
        
        $brand = new brand();
        $brand->name = $request->name;
        $brand->img = $finalName;
        $brand->save();
        
        foreach ($request->category_id as $v) {
            $category_brand = new categoryBrand();
            $category_brand->category_id = $v;
            $category_brand->brand_id = $brand->id;
            $category_brand->save();
        }

        return redirect(aurl('brands'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $single = brand::find($id);
        $allcategories = category::all();
        $parents = category::whereNotNull('parentID')->get();
        foreach ($parents as $item){
            $parentID[] = $item->parentID; 
        }
        $data = array(
            'single' => $single,
            'allcategories' => $allcategories,
            'parentID' => $parentID
        ); 
        return view('admin.brands.edit')->with($data);
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
            'img' => 'image|nullable|max:2048',
            'name' => 'required',
            'category_id' => 'required',
            ]);

        $single = brand::find($id);

        if($request->hasFile('img')){ 

            $allowedExt = array('png','jpg', 'jpe', 'jpeg');

            $fullName = $request->file('img')->getClientOriginalName();

            $name = pathinfo($fullName, PATHINFO_FILENAME);

            $ext = $request->file('img')->getClientOriginalExtension();

            if(in_array($ext, $allowedExt)){

            //delete the privious image
            storage::disk('uploads')->delete("brandImg/$single->img");

                $finalName = $name . '-' . time() . '.' .  $ext;
                $storePath = 'brandImg/';
                $request->file('img')->storePubliclyAs($storePath, $finalName, 'uploads');
            }else{
                return redirect(aurl("brands/$id/edit"))->with('error', 'The ext is not allowed');
            } 
        }else{
            $finalName = $single->img;
        }

                
        $single->name = $request->name;
        $single->img = $finalName;
        $single->save();

        $del_cat_brand = categoryBrand::where('brand_id', $id);
        $del_cat_brand->delete();
        
        foreach ($request->category_id as $v) {
            $category_brand = new categoryBrand();
            $category_brand->category_id = $v;
            $category_brand->brand_id = $single->id;
            $category_brand->save();
        }

        return redirect(aurl('brands'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSingle($id)
    {
        //delete the image from the disk
        $single = brand::find($id);
        storage::disk('uploads')->delete("brandImg/$single->img");

        $delete = brand::where('id', $id);
        $delete->delete();

        $del_cat_brand = categoryBrand::where('brand_id', $id);
        $del_cat_brand->delete();

        return redirect(aurl('brands'));
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
            return redirect(aurl('brands'));
        }

        //delete the images from the disk
        foreach ($id as $v) {
            $single = brand::find($v);
            storage::disk('uploads')->delete("brandImg/$single->img");
        }

        $delete = brand::whereIn('id', $id);
        $delete->delete();

        $del_cat_brand = categoryBrand::whereIn('brand_id', $id);
        $del_cat_brand->delete();

        return redirect(aurl('brands'));
    }
}
