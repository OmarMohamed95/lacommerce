<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function brand(){
        return $this->belongsTo('App\Model\Brand');
    }

    public function category(){
        return $this->belongsTo('App\Model\Category');
    }

    public function productImg(){
        return $this->hasMany('App\Model\ProductImg');
    }

    public function customField(){
        return $this->belongsToMany('App\Model\CustomField', 'custom_field_products', 'product_id', 'custom_field_id');
    }
}
