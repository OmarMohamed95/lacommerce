<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    public function products(){
        return $this->belongsTo('App\Model\Product', 'product_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\Model\User');
    }
}
