<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class productImg extends Model
{
    public $timestamps = false;

    public function product(){
        return $this->belongsTo('App\adminModel\product');
    }
}
