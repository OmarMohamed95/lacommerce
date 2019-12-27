<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\customField;
use App\adminModel\customFieldCategory;
use App\adminModel\category;

class custom_field extends Controller
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
        $allcategories = category::all();
        $parents = category::whereNotNull('parentID')->get();
        foreach ($parents as $item){
            $parentID[] = $item->parentID; 
        }

        $data = array(
            'allcategories' => $allcategories,
            'parentID' => $parentID
        );

        return view('admin.customField.create')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $CF_byCategory = customFieldCategory::with('custom_field')->where('category_id', $id)->get();

        $cf = array();
        foreach($CF_byCategory as $c){
            array_push($cf, $c->custom_field->first());
        }

        return response()->json($cf, 200);   
    }

    public function editProduct($id, $product_id)
    {

        $CF_product = customFieldCategory::with(['custom_field', 'custom_field_product' => function ($query) use ($product_id){
            $query->where('product_id', '=', $product_id);
        }])->where('category_id', $id)->get();

        return response()->json($CF_product, 200);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $messages = [
            'required' => 'The :attribute is required.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'show_in_filter' => 'required',
            'category_id' => 'required',
        ], $messages);

        $store_cf = new customField();
        
        $store_cf->name = $request->name;
        $store_cf->type = $request->type;
        $store_cf->show_in_filter = $request->show_in_filter;
        $store_cf->save();
        
        foreach($request->category_id as $i){
            $store_cf_c = new customFieldCategory();
            $store_cf_c->category_id = $i;
            $store_cf_c->custom_field_id = $store_cf->id;
            $store_cf_c->save();
        }

        return redirect(aurl('custom_field'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $single = customField::where('id', $id)->first();

        foreach ($single->custom_field_category as $v) {
            $cf_cate[] = $v->category_id;
        }

        $allcategories = category::all();
        $parents = category::whereNotNull('parentID')->get();
        foreach ($parents as $item){
            $parentID[] = $item->parentID; 
        }

        $data = array(
            'single' => $single,
            'cf_cate' => $cf_cate,
            'allcategories' => $allcategories,
            'parentID' => $parentID,
        );

        return view('admin.customField.edit')->with($data);
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

        $messages = [
            'required' => 'The :attribute is required.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'show_in_filter' => 'required',
            'category_id' => 'required',
        ], $messages);

        $update = customField::find($id);
        $update->name = $request->name;
        $update->type = $request->type;
        $update->show_in_filter = $request->show_in_filter;
        $update->save();

        $delete_cf_cat = customFieldCategory::where('custom_field_id', $id);
        $delete_cf_cat->delete();

        foreach($request->category_id as $i){
            $store_cf_c = new customFieldCategory();
            $store_cf_c->category_id = $i;
            $store_cf_c->custom_field_id = $update->id;
            $store_cf_c->save();
        }

        return redirect(aurl('custom_field'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSingle($id)
    {
        $delete = customField::where('id', $id);
        $delete->delete();
        return redirect(aurl('custom_field'));
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
            return redirect(aurl('custom_field'));
        }
        $delete = customField::whereIn('id', $id);
        $delete->delete();
        return redirect(aurl('custom_field'));
    }
}
