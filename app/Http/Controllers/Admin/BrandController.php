<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Model\Brand;
use App\Model\Category;
use App\Model\CategoryBrand;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\PhotoExtensionNotAllowedException;
use App\Contracts\PhotoServiceInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CategoryBrandRepositoryInterface;
use App\Services\CategoryService;

/**
 * Brands Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class BrandController extends Controller
{
    const DEFAULT_IMAGE = 'no-image-available.jpg';

    /**
     * Brand Repository
     *
     * @param BrandRepositoryInterface $brandRepository
     */
    private $brandRepository;
    
    /**
     * Photo Service
     *
     * @param PhotoServiceInterface $photoService
     */
    private $photoService;
    
    /**
     * Category Service
     *
     * @param CategoryService $categoryService
     */
    private $categoryService;
    
    /**
     * CategoryBrand Repository
     *
     * @param CategoryBrandRepositoryInterface $categoryBrandRepository
     */
    private $categoryBrandRepository;

    public function __construct(
        BrandRepositoryInterface $brandRepository,
        PhotoServiceInterface $photoService,
        CategoryService $categoryService,
        CategoryBrandRepositoryInterface $categoryBrandRepository
    ) {
        $this->brandRepository = $brandRepository;
        $this->photoService = $photoService;
        $this->categoryService = $categoryService;
        $this->categoryBrandRepository = $categoryBrandRepository;
    }

    /**
     * Index action
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $allBrands = $this->brandRepository->getAllPaginated(10);
        return view('admin.brands.index')->with('brands', $allBrands);
    }

    /**
     * Create action
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subCategories = $this->categoryService->getSubCategories();

        return view('admin.brands.create')->with('categories', $subCategories);
    }

    /**
     * Store action
     *
     * @param BrandRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BrandRequest $request)
    {
        $storedPhotosNames[] = self::DEFAULT_IMAGE;
        if ($request->hasFile('img')) {
            try {
                $storedPhotosNames = $this->photoService
                    ->setStorePath('brandImg/')
                    ->store();
            } catch (PhotoExtensionNotAllowedException $th) {
                return redirect()
                    ->route("admin_brand_create")
                    ->with('error', __('messages.error.ext_not_allowed', ['ext' => $th->getMessage()]));
            }
        }
        
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->img = $storedPhotosNames[0];
        $brand->save();
        
        foreach ($request->category_id as $categoryId) {
            $categoryBrand = new CategoryBrand();
            $categoryBrand->category_id = $categoryId;
            $categoryBrand->brand_id = $brand->id;
            $categoryBrand->save();
        }

        return redirect()->route('admin_brand_index');
    }

    /**
     * Edit page
     *
     * @param int $brandId
     * @return \Illuminate\View\View
     */
    public function edit(int $brandId)
    {
        $brand = $this->brandRepository->find($brandId);
        $subCategories = $this->categoryService->getSubCategories();

        return view('admin.brands.edit')->with(
            [
                'brand' => $brand,
                'categories' => $subCategories,
            ]
        );
    }

    /**
     * Update action
     *
     * @param BrandRequest $request
     * @param int $brandId
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BrandRequest $request, int $brandId)
    {
        $brand = $this->brandRepository->find($brandId);

        $storedPhotosNames[] = $brand->img;
        if ($request->hasFile('img')) {
            try {
                $storedPhotosNames = $this->photoService
                    ->setStorePath('brandImg/')
                    ->store();
            } catch (PhotoExtensionNotAllowedException $th) {
                return redirect()
                    ->route("admin_brand_edit", ['brandId' => $brandId])
                    ->with('error', __('messages.error.ext_not_allowed', ['ext' => $th->getMessage()]));
            }
        }

        $brand->name = $request->name;
        $brand->img = $storedPhotosNames[0];
        $brand->save();

        $this->categoryBrandRepository->findByBrandQuery([$brandId])->delete();
        
        foreach ($request->category_id as $v) {
            $categoryBrand = new CategoryBrand();
            $categoryBrand->category_id = $v;
            $categoryBrand->brand_id = $brand->id;
            $categoryBrand->save();
        }

        return redirect()->route('admin_brand_index');
    }

    /**
     * Delete action
     *
     * @param Request $request
     * @param int $brandId
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, int $brandId = null)
    {
        $brandIds = $brandId ? [$brandId] : $request->id;
        if (empty($brandIds)) {
            return redirect()->route('admin_brand_index');
        }

        $this->brandRepository->getBrandsQuery($brandIds)->delete();

        $this->categoryBrandRepository->findByBrandQuery($brandIds)->delete();

        return redirect()->route('admin_brand_index');
    }
}
