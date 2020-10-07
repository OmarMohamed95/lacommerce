<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\adminModel\brand;
use App\adminModel\category;
use App\adminModel\categoryBrand;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\PhotoExtensionNotAllowedException;
use App\Contracts\PhotoServiceInterface;

/**
 * Brands Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class BrandController extends Controller
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
        $allCategories = category::all();
        $parents = category::whereNotNull('parentID')->get();
        foreach ($parents as $item) {
            $parentId[] = $item->parentID; 
        }
    
        $data = [
            'allcategories' => $allCategories,
            'parentID' => $parentId ?? [],
        ];
        return view('admin.brands.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\BrandRequest $request Request object
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $storedPhotosNames[] = 'no-image-available.jpg';
        if ($request->hasFile('img')) {
            try {
                $storedPhotosNames = $this->PhotoService
                    ->setStorePath('brandImg/')
                    ->store();
            } catch (PhotoExtensionNotAllowedException $th) {
                return redirect(aurl("brands/create"))
                    ->with('error', __('messages.error.ext_not_allowed', ['ext' => $th->getMessage()]));
            }
        }
        
        $brand = new brand();
        $brand->name = $request->name;
        $brand->img = $storedPhotosNames[0];
        $brand->save();
        
        foreach ($request->category_id as $v) {
            $categoryBrand = new categoryBrand();
            $categoryBrand->category_id = $v;
            $categoryBrand->brand_id = $brand->id;
            $categoryBrand->save();
        }

        return redirect(aurl('brands'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id The brand id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = brand::find($id);
        $allCategories = category::all();
        $parents = category::whereNotNull('parentID')->get();

        if ($parents) {
            foreach ($parents as $parent) {
                $parentId[] = $parent->parentID; 
            }
        }

        $data = [
            'single' => $brand,
            'allcategories' => $allCategories,
            'parentID' => $parentId ?? []
        ];

        return view('admin.brands.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\BrandRequest $request Request object
     * @param int $id Brand id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $brand = brand::find($id);

        $storedPhotosNames[] = $brand->img;
        if ($request->hasFile('img')) {
            try {
                $storedPhotosNames = $this->PhotoService
                    ->setStorePath('brandImg/')
                    ->store();
            } catch (PhotoExtensionNotAllowedException $th) {
                return redirect(aurl("brands/$id/edit"))
                    ->with('error', __('messages.error.ext_not_allowed', ['ext' => $th->getMessage()]));
            }
        }

        $brand->name = $request->name;
        $brand->img = $storedPhotosNames[0];
        $brand->save();

        $categoryBrand = categoryBrand::where('brand_id', $id);
        $categoryBrand->delete();
        
        foreach ($request->category_id as $v) {
            $categoryBrand = new categoryBrand();
            $categoryBrand->category_id = $v;
            $categoryBrand->brand_id = $brand->id;
            $categoryBrand->save();
        }

        return redirect(aurl('brands'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $brandId Brand id
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteSingle($brandId)
    {
        $brand = brand::find($brandId);
        $brand->delete();

        $categoryBrand = categoryBrand::where('brand_id', $brandId);
        $categoryBrand->delete();

        return redirect(aurl('brands'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request Request object
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteMultible(Request $request)
    {
        $brandIDs = $request->id;
        if (empty($brandIDs)) {
            return redirect(aurl('brands'));
        }

        $brand = brand::whereIn('id', $brandIDs);
        $brand->delete();

        $categoryBrand = categoryBrand::whereIn('brand_id', $brandIDs);
        $categoryBrand->delete();

        return redirect(aurl('brands'));
    }
}
