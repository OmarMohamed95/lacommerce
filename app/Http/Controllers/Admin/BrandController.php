<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * @param \Illuminate\Http\Request $request Request object
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'img' => 'image|nullable|max:2048',
                'name' => 'required',
                'category_id' => 'required',
            ]
        );

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
        $single = brand::find($id);
        $allCategories = category::all();
        $parents = category::whereNotNull('parentID')->get();

        foreach ($parents as $item) {
            $parentId[] = $item->parentID; 
        }

        $data = [
            'single' => $single,
            'allcategories' => $allCategories,
            'parentID' => $parentId
        ];

        return view('admin.brands.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request Request object
     * @param int $id Brand id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'img' => 'image|nullable|max:2048',
                'name' => 'required',
                'category_id' => 'required',
            ]
        );

        $single = brand::find($id);

        if ($request->hasFile('img')) { 

            $allowedExt = ['png','jpg', 'jpe', 'jpeg'];

            $fullName = $request->file('img')->getClientOriginalName();

            $name = pathinfo($fullName, PATHINFO_FILENAME);

            $ext = $request->file('img')->getClientOriginalExtension();

            if (in_array($ext, $allowedExt)) {

                //delete the privious image
                storage::disk('uploads')->delete("brandImg/$single->img");

                $finalName = $name . '-' . time() . '.' .  $ext;
                $storePath = 'brandImg/';
                $request
                    ->file('img')
                    ->storePubliclyAs($storePath, $finalName, 'uploads');
            } else {
                return redirect(aurl("brands/$id/edit"))
                            ->with('error', 'The ext is not allowed');
            } 
        } else {
            $finalName = $single->img;
        }

                
        $single->name = $request->name;
        $single->img = $finalName;
        $single->save();

        $categoryBrand = categoryBrand::where('brand_id', $id);
        $categoryBrand->delete();
        
        foreach ($request->category_id as $v) {
            $categoryBrand = new categoryBrand();
            $categoryBrand->category_id = $v;
            $categoryBrand->brand_id = $single->id;
            $categoryBrand->save();
        }

        return redirect(aurl('brands'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id Brand id
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteSingle($id)
    {
        //delete the image from the disk
        $single = brand::find($id);
        storage::disk('uploads')->delete("brandImg/$single->img");

        $brand = brand::where('id', $id);
        $brand->delete();

        $categoryBrand = categoryBrand::where('brand_id', $id);
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
        $id = $request->id;
        if (empty($id)) {
            return redirect(aurl('brands'));
        }

        //delete the images from the disk
        foreach ($id as $v) {
            $single = brand::find($v);
            storage::disk('uploads')->delete("brandImg/$single->img");
        }

        $brand = brand::whereIn('id', $id);
        $brand->delete();

        $categoryBrand = categoryBrand::whereIn('brand_id', $id);
        $categoryBrand->delete();

        return redirect(aurl('brands'));
    }
}
