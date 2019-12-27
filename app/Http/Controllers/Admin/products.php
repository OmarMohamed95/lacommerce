<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\adminModel\product;
use App\adminModel\brand;
use App\adminModel\productImg;
use App\adminModel\category;
use App\adminModel\customFieldProduct;
use App\adminModel\categoryBrand;
use DB;
use Image;

class products extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allProducts = product::where('offer', 0)->paginate(10);
        return view('admin.products.index')->with('allProducts', $allProducts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBrandsByCat($cat_id)
    {
        $allBrands = categoryBrand::with('brand')->where('category_id', $cat_id)->get();
        return response()->json($allBrands, 200);
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
            'parentID' => $parentID
        );

        return view('admin.products.create')->with($data);
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
            'img.*' => 'bail|image|required|max:3072',
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required|numeric',
            'brand_id' => 'required',
            'quantity' => 'required|numeric',
            'category_id' => 'required',
            'cf.*' => 'required',
            ]);    

        //store products to DB
        $product = new product;
        $product->name = $request->name;        
        $product->desc = $request->desc;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->save();

        if($request->hasFile('img')){

            foreach ($request->file('img') as $file) {

                $allowedExt = array('png','jpg', 'jpe', 'jpeg');

                $fullName = $file->getClientOriginalName();

                $name = pathinfo($fullName, PATHINFO_FILENAME);

                $ext = $file->getClientOriginalExtension();

                if(in_array($ext, $allowedExt)){

                    $finalName = $name . '-' . time() . '.' .  $ext;

                    $storePath = 'productImg/';

                    $file->storePubliclyAs($storePath, $finalName, 'uploads');

                    //Resize image - main img
                    //$img = Image::make($file)->resize(350, 400);
                    //$location = Storage::disk('uploads')->put('productImgThumbnailMain/' . $finalName, (string) $img->encode());

                    //Resize image here - galary img
                    //$img = Image::make($file)->resize(270, 320);
                    //$location = Storage::disk('uploads')->put('productImgThumbnailGallary/' . $finalName, (string) $img->encode());

                    // store images to DB
                    $productImg = new productImg;
                    $productImg->product_id = $product->id;
                    $productImg->img = $finalName;
                    $productImg->save();

                }else{
                    return redirect(aurl("products/create"))->with('error', 'The ext is not allowed');
                }
            }
        }

        //store custom fields values to DB
        if($request->cf){
            foreach($request->cf as $key => $value){
                $custom_field = new customFieldProduct;
                $custom_field->product_id = $product->id;
                $custom_field->custom_field_id = $key;
                $custom_field->value = $value;
                $custom_field->save();
            }
        }

        return redirect(aurl('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $single = product::where('id', $id)->first();
        $productImg = productImg::where('product_id', $id)->get();
        $data = array(
            'single' => $single,
            'productImg' => $productImg
        );
        return view('admin.products.preview')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $single = product::find($id);
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
        return view('admin.products.edit')->with($data);
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
            'img.*' => 'bail|image|required|max:3072',
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required|numeric',
            'brand_id' => 'required',
            'quantity' => 'required|numeric',
            'category_id' => 'required',
            'cf.*' => 'required',
            ]);   

        //update product in DB
        $update = product::find($id); 
        $update->name = $request->name;        
        $update->desc = $request->desc;
        $update->brand_id = $request->brand_id;
        $update->price = $request->price;
        $update->quantity = $request->quantity;
        $update->category_id = $request->category_id;
        $update->save();    

        if($request->hasFile('img')){

        //delete the image from the disk
        $singleD = productImg::where('product_id', $id)->get();
        foreach ($singleD as $s) {
            storage::disk('uploads')->delete("productImg/$s->img");
        }    

        //delete image from DB
        $single = productImg::where('product_id', $id);
        $single->delete();

            foreach ($request->file('img') as $file) {

                $allowedExt = array('png','jpg', 'jpe', 'jpeg');

                $fullName = $file->getClientOriginalName();

                $name = pathinfo($fullName, PATHINFO_FILENAME);

                $ext = $file->getClientOriginalExtension();

                if(in_array($ext, $allowedExt)){

                    $finalName = $name . '-' . time() . '.' .  $ext;

                    $storePath = 'productImg/';

                    //store the new image
                    $file->storePubliclyAs($storePath, $finalName, 'uploads');

                    // store images to DB
                    $productImg = new productImg;
                    $productImg->product_id = $update->id;
                    $productImg->img = $finalName;
                    $productImg->save();

                }else{
                    return redirect(aurl("products/$id/edit"))->with('error', 'The ext is not allowed');
                }
            }
        }

        if($request->cf){
            //delete old custom field values
            $delete_cf_product = customFieldProduct::where('product_id', $id);
            $delete_cf_product->delete();

            //store custom fields values to DB
            foreach($request->cf as $key => $value){
                $custom_field = new customFieldProduct;
                $custom_field->product_id = $update->id;
                $custom_field->custom_field_id = $key;
                $custom_field->value = $value;
                $custom_field->save();
            }
        }

        return redirect(aurl('products'))->with('success', 'product updated');
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
        $singleD = productImg::where('product_id', $id)->get();
        foreach ($singleD as $s) {
            storage::disk('uploads')->delete("productImg/$s->img");
        }

        //delete image from DB
        $single = productImg::where('product_id', $id);
        $single->delete();

        //delete product from DB
        $delete = product::where('id', $id);
        $delete->delete();
        return redirect(aurl('products'));
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
            return redirect(aurl('products'));
        }

        //delete the image from the disk
        $singleD = productImg::whereIn('product_id', $id)->get();
        foreach ($singleD as $s) {
            storage::disk('uploads')->delete("productImg/$s->img");
        }

        //delete image from DB
        $single = productImg::whereIn('product_id', $id);
        $single->delete();

        //delete product from DB
        $delete = product::whereIn('id', $id);
        $delete->delete();
        return redirect(aurl('products'));
    }
}
