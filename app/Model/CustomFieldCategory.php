<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomFieldCategory extends Model
{
    protected $table = 'custom_field_categories';
    public $timestamps = false;
    //protected $primaryKey = null;
    //public $incrementing = false;

    public function customField()
    {
        return $this->hasMany(CustomField::class, 'id', 'custom_field_id');
    }

    public function customFieldProduct()
    {
        return $this->hasMany(CustomFieldProduct::class, 'custom_field_id', 'custom_field_id');
    }
}
