<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminModel\review;

class reviews extends Controller
{
    public function index(){

        $all = review::paginate(10);

        return view('admin.reviews.index')->with('all', $all);
    }

    public function overview($id){

        $single = review::where('id', $id)->first();

        return view('admin.reviews.overview')->with('single', $single);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSingle($id)
    {
        //delete reviews from DB
        $delete = review::where('id', $id);
        $delete->delete();
        return redirect(aurl('reviews'));
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
            return redirect(aurl('reviews'));
        }

        //delete reviews from DB
        $delete = review::whereIn('id', $id);
        $delete->delete();
        return redirect(aurl('reviews'));
    }
}
