<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Category;
use DB;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Contracts\CategoryRepositoryInterface;

/**
 * Categories Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface $categoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Index action
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryRepository->getAllPaginated(10);
        return view('admin.categories.index')->with('categories', $categories);
    }

    /**
     * Create page
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $parentCategories = $this->categoryRepository->getParentCategories();

        return view('admin.categories.create')
            ->with('parentCategores', $parentCategories);
    }

    /**
     * Store action
     *
     * @param CategoryRequest $request 
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->parentID = ($request->parentID == 'none') ? null : $request->parentID;
        $category->status = $request->status;
        $category->sort = $request->sort;
        $category->home = $request->home;
        $category->admin_id = Auth::id();
        $category->save();

        return redirect()->route('admin_category_index');
    }

    /**
     * edit page
     *
     * @param int $categoryId
     * 
     * @return \Illuminate\View\View
     */
    public function edit($categoryId)
    {
        $parentCategories = $this->categoryRepository->getParentCategories();
        $category = $this->categoryRepository->find($categoryId);
        
        return view('admin.categories.edit')->with(
            [
                'parentCategories' => $parentCategories,
                'category' => $category
            ]
        );
    }

    /**
     * Update action
     *
     * @param CategoryRequest $request
     * @param int $categoryId
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, int $categoryId)
    {
        $category = $this->categoryRepository->find($categoryId);

        $category->name = $request->name;
        $category->parentID = ($request->parentID == 'none') ? null : $request->parentID;
        $category->status = $request->status;
        $category->sort = $request->sort;
        $category->home = $request->home;
        $category->admin_id = Auth::guard('admin')->user()->id;
        $category->save();

        return redirect()->route('admin_category_index');
    }

    /**
     * Delete action
     *
     * @param Request $request
     * @param int|null $categoryId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, int $categoryId = null)
    {
        $categoryIds = $categoryId ? [$categoryId] : $request->id;
        if (empty($categoryIds)) {
            return redirect()->route('admin_category_index');
        }

        $this->categoryRepository->getCategoriesByIdsQuery($categoryIds)->delete();
        
        return redirect()->route('admin_category_index');
    }
}
