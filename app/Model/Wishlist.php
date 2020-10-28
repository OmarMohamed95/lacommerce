<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public function products(){
        return $this->hasMany('App\Model\Product', 'id', 'product_id');
    }
}
