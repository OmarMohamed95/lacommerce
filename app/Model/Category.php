<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function admin(){
        return $this->belongsTo('App\Model\Admin');
    }

    public function children() {
        return $this->hasMany('App\Model\Category','parentID');
    }

    public function parent() {
        return $this->belongsTo('App\Model\Category','parentID');
    }

    public function products() {
        return $this->hasMany('App\Model\Product');
    }

    public function brands() {
        return $this->belongsToMany('App\Model\Brand', 'category_brand', 'category_id', 'brand_id');
    }
}
