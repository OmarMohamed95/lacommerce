<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{

    protected $table = 'custom_fields';

    public function customFieldProduct(){
        return $this->hasMany('App\Model\CustomFieldProduct');
    }

    public function customFieldCategory(){
        return $this->hasMany('App\Model\CustomFieldCategory', 'custom_field_id', 'id');
    }
}
