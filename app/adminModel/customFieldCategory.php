<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class customFieldCategory extends Model
{
    protected $table = 'custom_field_categories';
    public $timestamps = false;
    //protected $primaryKey = null;
    //public $incrementing = false;

    public function custom_field(){
        return $this->hasMany('App\adminModel\customField', 'id', 'custom_field_id');
    }

    public function custom_field_product(){
        return $this->hasMany('App\adminModel\customFieldProduct', 'custom_field_id', 'custom_field_id');
    }
}
