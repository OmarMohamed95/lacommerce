<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\customField;
use App\adminModel\customFieldCategory;
use App\adminModel\category;

/**
 * Custom field Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCust = customField::paginate(10);
        return view('admin.customField.index')->with('allCustomField', $allCust);
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

        return view('admin.customField.create')->with($data);
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
        $customFieldByCategory = customFieldCategory::with('custom_field')
                            ->where('category_id', $id)
                            ->get();

        $cf = [];
        foreach ($customFieldByCategory as $c) {
            array_push($cf, $c->custom_field->first());
        }

        return response()->json($cf, 200);   
    }

    /**
     * Edit product
     *
     * @param int $id 
     * @param int $productId 
     * 
     * @return \Illuminate\Http\Response
     */
    public function editProduct($id, $productId)
    {
        $customFieldProduct = customFieldCategory::with(
            [
                'custom_field',
                'custom_field_product' => function ($query) use ($productId) {
                    $query->where('product_id', '=', $productId);
                }
            ]
        )
        ->where('category_id', $id)->get();

        return response()->json($customFieldProduct, 200);   
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

        $messages = [
            'required' => 'The :attribute is required.',
        ];

        $this->validate(
            $request,
            [
                'name' => 'required',
                'type' => 'required',
                'show_in_filter' => 'required',
                'category_id' => 'required',
            ],
            $messages
        );

        $customField = new customField();
        
        $customField->name = $request->name;
        $customField->type = $request->type;
        $customField->show_in_filter = $request->show_in_filter;
        $customField->save();
        
        foreach ($request->category_id as $i) {
            $customFieldCategory = new customFieldCategory();
            $customFieldCategory->category_id = $i;
            $customFieldCategory->custom_field_id = $store_cf->id;
            $customFieldCategory->save();
        }

        return redirect(aurl('custom_field'));
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
        $single = customField::where('id', $id)->first();

        foreach ($single->custom_field_category as $v) {
            $customFieldCategories[] = $v->category_id;
        }

        $allCategories = category::all();
        $parents = category::whereNotNull('parentID')->get();
        foreach ($parents as $item) {
            $parentIds[] = $item->parentID; 
        }

        $data = [
            'single' => $single,
            'cf_cate' => $customFieldCategories,
            'allcategories' => $allCategories,
            'parentID' => $parentIds,
        ];

        return view('admin.customField.edit')->with($data);
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
        $messages = [
            'required' => 'The :attribute is required.',
        ];

        $this->validate(
            $request,
            [
                'name' => 'required',
                'type' => 'required',
                'show_in_filter' => 'required',
                'category_id' => 'required',
            ],
            $messages
        );

        $update = customField::find($id);
        $update->name = $request->name;
        $update->type = $request->type;
        $update->show_in_filter = $request->show_in_filter;
        $update->save();

        $customFieldByCategory = customFieldCategory::where('custom_field_id', $id);
        $customFieldByCategory->delete();

        foreach ($request->category_id as $i) {
            $customFieldByCategory = new customFieldCategory();
            $customFieldByCategory->category_id = $i;
            $customFieldByCategory->custom_field_id = $update->id;
            $customFieldByCategory->save();
        }

        return redirect(aurl('custom_field'));
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
        $customField = customField::where('id', $id);
        $customField->delete();
        return redirect(aurl('custom_field'));
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
            return redirect(aurl('custom_field'));
        }

        $customField = customField::whereIn('id', $id);
        $customField->delete();
        return redirect(aurl('custom_field'));
    }
}
