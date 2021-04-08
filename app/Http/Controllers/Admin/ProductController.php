<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductImg;
use App\Model\Category;
use App\Model\CustomFieldProduct;
use App\Model\CategoryBrand;
use App\Contracts\PhotoServiceInterface;
use App\Events\ProductCreated;
use App\Events\ProductDeleted;
use App\Events\ProductUpdated;
use App\Exceptions\PhotoExtensionNotAllowedException;
use App\Http\Requests\ProductRequest;

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
     * @param PhotoServiceInterface $photoService
     */
    private $photoService;

    public function __construct(PhotoServiceInterface $photoService)
    {
        $this->photoService = $photoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allProducts = Product::where('offer', 0)->paginate(10);
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
        $allBrands = CategoryBrand::with('brand')
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
        $allCategories = Category::all();
        $parents = Category::whereNotNull('parentID')->get();
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
     * @param App\Http\Requests\ProductRequest $request 
     * 
     * @return \Illuminate\Http\Response
     * 
     * @throws PhotoExtensionNotAllowedException
     */
    public function store(ProductRequest $request)
    { 
        if ($request->hasFile('img')) {
            try {
                $storedPhotosNames = $this->photoService
                    ->setStorePath('productImg/')
                    ->store();
            } catch (PhotoExtensionNotAllowedException $th) {
                return redirect(aurl("products/create"))
                    ->with('error', __('messages.error.ext_not_allowed', ['ext' => $th->getMessage()]));
            }
        }

        $product = new Product;
        $product->name = $request->name;        
        $product->desc = $request->desc;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->save();

        if (isset($storedPhotosNames) && $storedPhotosNames) {
            foreach ($storedPhotosNames as $photoName) {
                $productImg = new ProductImg;
                $productImg->product_id = $product->id;
                $productImg->img = $photoName;
                $productImg->save();
            }
        }

        if ($request->cf) {
            foreach ($request->cf as $key => $value) {
                $customFieldProduct = new CustomFieldProduct;
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
        $single = Product::where('id', $id)->first();
        $productImg = ProductImg::where('product_id', $id)->get();
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
        $single = Product::find($id);
        $allCategories = Category::all();
        $parents = Category::whereNotNull('parentID')->get();

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
     * @param App\Http\Requests\ProductRequest $request 
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id); 
        $product->name = $request->name;        
        $product->desc = $request->desc;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->save();    

        if ($request->hasFile('img')) {
            try {
                $productImages = ProductImg::where('product_id', $id);
                $this->photoService
                    ->setStorePath('productImg/')
                    ->delete($productImages->get());

                $productImages->delete();

                $storedPhotosNames = $this->photoService
                    ->setStorePath('productImg/')
                    ->store();
            } catch (PhotoExtensionNotAllowedException $th) {
                return redirect(aurl("products/$id/edit"))
                    ->with('error', __('messages.error.ext_not_allowed', ['ext' => $th->getMessage()]));
            }

            foreach ($storedPhotosNames as $photo) {
                $productImg = new ProductImg;
                $productImg->product_id = $product->id;
                $productImg->img = $photo;
                $productImg->save();
            }
        }

        if ($request->cf) {
            //delete old custom field values
            $customFieldProduct = CustomFieldProduct::where('product_id', $id);
            $customFieldProduct->delete();

            //store custom fields values to DB
            foreach ($request->cf as $key => $value) {
                $customFieldProduct = new CustomFieldProduct;
                $customFieldProduct->product_id = $product->id;
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
        $productImages = ProductImg::where('product_id', $id);
        
        $this->photoService
            ->setStorePath('productImg/')
            ->delete($productImages->get());

        $productImages->delete();

        $product = Product::find($id);
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
        $ids = $request->id;
        if (empty($ids)) {
            return redirect(aurl('products'));
        }

        $productImages = ProductImg::whereIn('product_id', $ids);
        $this->photoService
            ->setStorePath('productImg/')
            ->delete($productImages->get());

        $productImages->delete();

        $products = Product::whereIn('id', $ids)->get();

        // loop through the products and delete them one by one
        // instaed of calling delete() on many products
        // to dispatch the deleting event
        foreach ($products as $product) {
            $product->delete();
        }
        
        return redirect(aurl('products'));
    }
}
