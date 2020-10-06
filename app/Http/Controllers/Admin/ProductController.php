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
use App\Contracts\PhotoServiceInterface;
use App\Exceptions\PhotoExtensionNotAllowedException;

/**
 * ProductController
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class ProductController extends Controller
{
    /**
     * Photo Service
     *
     * @param PhotoServiceInterface $PhotoService
     */
    private $PhotoService;

    public function __construct(PhotoServiceInterface $PhotoService)
    {
        $this->PhotoService = $PhotoService;
    }

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
     * @param int $categoryId 
     * 
     * @return \Illuminate\Http\Response
     */
    public function getBrandsByCat($categoryId)
    {
        $allBrands = categoryBrand::with('brand')
                        ->where('category_id', $categoryId)
                        ->get();
        return response()->json($allBrands, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allCategories = category::all();
        $parents = category::whereNotNull('parentID')->get();
        foreach ($parents as $item) {
            $parentIds[] = $item->parentID; 
        }
    
        $data = [
            'allcategories' => $allCategories,
            'parentID' => $parentIds ?? [],
        ];

        return view('admin.products.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response
     * 
     * @throws PhotoExtensionNotAllowedException
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'img.*' => 'bail|image|required|max:3072',
                'name' => 'required',
                'desc' => 'required',
                'price' => 'required|numeric',
                'brand_id' => 'required',
                'quantity' => 'required|numeric',
                'category_id' => 'required',
                'cf.*' => 'required',
            ]
        );    

        if ($request->hasFile('img')) {
            try {
                $storedPhotosNames = $this->PhotoService
                    ->setStorePath('productImg/')
                    ->store();
            } catch (PhotoExtensionNotAllowedException $th) {
                return redirect(aurl("products/create"))
                    ->with('error', __('messages.error.ext_not_allowed', ['ext' => $th->getMessage()]));
            }
        }

        $product = new product;
        $product->name = $request->name;        
        $product->desc = $request->desc;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->save();

        if (isset($storedPhotosNames) && $storedPhotosNames) {
            foreach ($storedPhotosNames as $photoName) {
                $productImg = new productImg;
                $productImg->product_id = $product->id;
                $productImg->img = $photoName;
                $productImg->save();
            }
        }

        if ($request->cf) {
            foreach ($request->cf as $key => $value) {
                $customFieldProduct = new customFieldProduct;
                $customFieldProduct->product_id = $product->id;
                $customFieldProduct->custom_field_id = $key;
                $customFieldProduct->value = $value;
                $customFieldProduct->save();
            }
        }

        return redirect(aurl('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $single = product::where('id', $id)->first();
        $productImg = productImg::where('product_id', $id)->get();
        $data = [
            'single' => $single,
            'productImg' => $productImg
        ];
        return view('admin.products.preview')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id 
     *  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $single = product::find($id);
        $allCategories = category::all();
        $parents = category::whereNotNull('parentID')->get();

        foreach ($parents as $item) {
            $parentIds[] = $item->parentID; 
        }

        $data = [
            'single' => $single,
            'allcategories' => $allCategories,
            'parentID' => $parentIds
        ]; 
        return view('admin.products.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request 
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'img.*' => 'bail|image|required|max:3072',
                'name' => 'required',
                'desc' => 'required',
                'price' => 'required|numeric',
                'brand_id' => 'required',
                'quantity' => 'required|numeric',
                'category_id' => 'required',
                'cf.*' => 'required',
            ]
        );   

        //update product in DB
        $product = product::find($id); 
        $product->name = $request->name;        
        $product->desc = $request->desc;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->save();    

        if ($request->hasFile('img')) {

            //delete the image from the disk
            $singleD = productImg::where('product_id', $id)->get();
            foreach ($singleD as $s) {
                storage::disk('uploads')->delete("productImg/$s->img");
            }    

            //delete image from DB
            $single = productImg::where('product_id', $id);
            $single->delete();

            foreach ($request->file('img') as $file) {

                $allowedExt = ['png','jpg', 'jpe', 'jpeg'];

                $fullName = $file->getClientOriginalName();

                $name = pathinfo($fullName, PATHINFO_FILENAME);

                $ext = $file->getClientOriginalExtension();

                if (in_array($ext, $allowedExt)) {

                    $finalName = $name . '-' . time() . '.' .  $ext;

                    $storePath = 'productImg/';

                    //store the new image
                    $file->storePubliclyAs($storePath, $finalName, 'uploads');

                    // store images to DB
                    $productImg = new productImg;
                    $productImg->product_id = $update->id;
                    $productImg->img = $finalName;
                    $productImg->save();

                } else {
                    return redirect(aurl("products/$id/edit"))
                                ->with('error', 'The ext is not allowed');
                }
            }
        }

        if ($request->cf) {
            //delete old custom field values
            $customFieldProduct = customFieldProduct::where('product_id', $id);
            $customFieldProduct->delete();

            //store custom fields values to DB
            foreach ($request->cf as $key => $value) {
                $customFieldProduct = new customFieldProduct;
                $customFieldProduct->product_id = $update->id;
                $customFieldProduct->custom_field_id = $key;
                $customFieldProduct->value = $value;
                $customFieldProduct->save();
            }
        }

        return redirect(aurl('products'))
                    ->with('success', 'product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id 
     * 
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
        $productImg = productImg::where('product_id', $id);
        $productImg->delete();

        //delete product from DB
        $product = product::where('id', $id);
        $product->delete();
        return redirect(aurl('products'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteMultible(Request $request)
    {
        $id = $request->id;
        if (empty($id)) {
            return redirect(aurl('products'));
        }

        //delete the image from the disk
        $singleD = productImg::whereIn('product_id', $id)->get();
        foreach ($singleD as $s) {
            storage::disk('uploads')->delete("productImg/$s->img");
        }

        //delete image from DB
        $productImg = productImg::whereIn('product_id', $id);
        $productImg->delete();

        //delete product from DB
        $product = product::whereIn('id', $id);
        $product->delete();
        return redirect(aurl('products'));
    }
}
