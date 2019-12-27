<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
    public function products(){
        return $this->hasMany('App\adminModel\product', 'id', 'product_id');
    }
}
