<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class categoryBrand extends Model
{
    protected $table = 'category_brand';
    public $timestamps = false;

    public function brand(){
        return $this->belongsTo('App\adminModel\brand');
    }
}
