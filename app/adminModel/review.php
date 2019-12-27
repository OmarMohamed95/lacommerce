<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function product(){
        return $this->belongsTo('App\adminModel\product');
    }
}
