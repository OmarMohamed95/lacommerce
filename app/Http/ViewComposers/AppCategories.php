<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\adminModel\category;

class AppCategories {

    public function compose(View $view){
        $parents = category::where('parentID', null)->get();
        $view->with('parents', $parents);
    }
}