<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class brand extends Model
{
    //public function category(){
    //    return $this->belongsTo('App\adminModel\category', 'category_id');
    //}

    public function category(){
        return $this->belongsToMany('App\adminModel\category', 'category_brand', 'brand_id', 'category_id');
    }
}
