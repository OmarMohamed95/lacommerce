<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryBrand extends Model
{
    protected $table = 'category_brand';
    public $timestamps = false;

    public function brand(){
        return $this->belongsTo('App\Model\Brand');
    }
}
