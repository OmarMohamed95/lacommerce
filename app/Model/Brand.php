<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //public function category(){
    //    return $this->belongsTo('App\Model\category', 'category_id');
    //}

    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_brand', 'brand_id', 'category_id');
    }
}
