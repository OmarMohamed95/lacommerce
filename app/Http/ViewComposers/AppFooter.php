<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\adminModel\sitting;

class AppFooter {

    public function compose(View $view){
        $sitting = sitting::orderBy('id', 'desc')->first();
        $view->with('sitting', $sitting);
    }
}