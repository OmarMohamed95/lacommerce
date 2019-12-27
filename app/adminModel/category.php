<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    public function Admin(){
        return $this->belongsTo('App\adminModel\Admin');
    }

    public function children() {
        return $this->hasMany('App\adminModel\category','parentID');
    }

    public function parent() {
        return $this->belongsTo('App\adminModel\category','parentID');
    }

    public function products() {
        return $this->hasMany('App\adminModel\product');
    }

    public function brands() {
        return $this->belongsToMany('App\adminModel\brand', 'category_brand', 'category_id', 'brand_id');
    }
}
