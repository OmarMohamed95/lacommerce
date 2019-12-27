<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    public function products(){
        return $this->hasMany('App\adminModel\product', 'id', 'product_id');
    }
}
