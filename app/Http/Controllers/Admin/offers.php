<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\offer;
use App\adminModel\product;
use App\adminModel\brand;
use App\adminModel\productImg;
use App\adminModel\category;
use App\adminModel\customFieldProduct;
use App\adminModel\categoryBrand;
use Image;
use App\Contracts\PhotoServiceInterface;
use App\Exceptions\PhotoExtensionNotAllowedException;

/**
 * Offers Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class offers extends Controller
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
        $allOffers = product::where('offer', 1)->paginate(10);
        return view('admin.offers.index')->with('allOffers', $allOffers);
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
            'parentID' => $parentIds
        ];

        return view('admin.offers.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return Redirect
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
            
        //store products to DB
        $product = new product;
        $product->name = $request->name;        
        $product->desc = $request->desc;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->offer = 1;
        $product->save();    

        if ($request->hasFile('img')) {
            try {
                $storedPhotosNames = $this->PhotoService
                    ->setStorePath('productImg/')
                    ->store();
            } catch (PhotoExtensionNotAllowedException $th) {
                return redirect(aurl("offers/create"))
                    ->with('error', __('messages.error.ext_not_allowed', ['ext' => $th->getMessage()]));
            }
        }

        foreach ($storedPhotosNames as $photo) {
            $productImg = new productImg;
            $productImg->product_id = $product->id;
            $productImg->img = $photo;
            $productImg->save();
        }

        //store custom fields values to DB
        if ($request->cf) {
            foreach ($request->cf as $key => $value) {
                $customField = new customFieldProduct;
                $customField->product_id = $product->id;
                $customField->custom_field_id = $key;
                $customField->value = $value;
                $customField->save();
            }
        }

        return redirect(aurl('offers'));
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
        return view('admin.offers.preview')->with($data);
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

        return view('admin.offers.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request 
     * @param int $id 
     * 
     * @return Redirect
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
        $product->offer = 1;
        $product->save();    

        if ($request->hasFile('img')) {
            try {
                $productImages = productImg::where('product_id', $id)->get();
                $this->PhotoService
                    ->setStorePath('productImg/')
                    ->delete($productImages);

                $productImages->delete();

                $storedPhotosNames = $this->PhotoService
                    ->setStorePath('productImg/')
                    ->store();
            } catch (PhotoExtensionNotAllowedException $th) {
                return redirect(aurl("offers/$id/edit"))
                    ->with('error', __('messages.error.ext_not_allowed', ['ext' => $th->getMessage()]));
            }
        }

        foreach ($storedPhotosNames as $photo) {
            $productImg = new productImg;
            $productImg->product_id = $product->id;
            $productImg->img = $photo;
            $productImg->save();
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

        return redirect(aurl('offers'))->with('success', 'Post updated');
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
        $productImages = productImg::where('product_id', $id);
        
        $this->PhotoService
            ->setStorePath('productImg/')
            ->delete($productImages->get());

        $productImages->delete();

        $product = product::where('id', $id);
        $product->delete();
        return redirect(aurl('offers'));
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
        $ids = $request->id;
        if (empty($ids)) {
            return redirect(aurl('offers'));
        }

        $productImages = productImg::whereIn('product_id', $ids);
        $this->PhotoService
            ->setStorePath('productImg/')
            ->delete($productImages->get());

        $productImages->delete();

        $product = product::whereIn('id', $ids);
        $product->delete();
        return redirect(aurl('offers'));
    }
}
