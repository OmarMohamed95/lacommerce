<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Model\Setting;

class AppFooter {

    public function compose(View $view){
        $sitting = Setting::orderBy('id', 'desc')->first();
        $view->with('sitting', $sitting);
    }
}