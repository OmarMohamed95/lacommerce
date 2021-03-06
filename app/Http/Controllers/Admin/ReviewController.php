<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Review;

/**
 * Reviews Controller
 * 
 * @author Omar Mohamed <omar.mo9516@gmail.com>
 */
class ReviewController extends Controller
{
    /**
     * Index mthod
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reviews = Review::paginate(10);

        return view('admin.reviews.index')->with('all', $reviews);
    }

    /**
     * Overview method
     * 
     * @param int $id 
     *
     * @return \Illuminate\Http\Response
     */
    public function overview($id)
    {

        $review = Review::where('id', $id)->first();

        return view('admin.reviews.overview')->with('single', $review);
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
        //delete reviews from DB
        $review = Review::where('id', $id);
        $review->delete();
        return redirect(aurl('reviews'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteMultible(Request $request)
    {
        $id = $request->id;
        if (empty($id)) {
            return redirect(aurl('reviews'));
        }

        //delete reviews from DB
        $review = Review::whereIn('id', $id);
        $review->delete();
        return redirect(aurl('reviews'));
    }
}
