<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class checkout extends Model
{
    public function products(){
        return $this->belongsTo('App\adminModel\product', 'product_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
