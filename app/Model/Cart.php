<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function products(){
        return $this->hasMany('App\Model\Product', 'id', 'product_id');
    }
}
