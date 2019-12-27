<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    public function brand(){
        return $this->belongsTo('App\adminModel\brand');
    }

    public function category(){
        return $this->belongsTo('App\adminModel\category');
    }

    public function productImg(){
        return $this->hasMany('App\adminModel\productImg');
    }

    public function custom_field(){
        return $this->belongsToMany('App\adminModel\customField', 'custom_field_products', 'product_id', 'custom_field_id');
    }
}
