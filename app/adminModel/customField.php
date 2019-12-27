<?php

namespace App\adminModel;

use Illuminate\Database\Eloquent\Model;

class customField extends Model
{

    protected $table = 'custom_fields';

    public function custom_field_product(){
        return $this->hasMany('App\adminModel\customFieldProduct');
    }

    public function custom_field_category(){
        return $this->hasMany('App\adminModel\customFieldCategory', 'custom_field_id', 'id');
    }
}
