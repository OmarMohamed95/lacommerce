<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Model\Category;

class AppCategories {

    public function compose(View $view){
        $parents = Category::where('parentID', null)->get();
        $view->with('parents', $parents);
    }
}