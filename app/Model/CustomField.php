<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{

    protected $table = 'custom_fields';

    public function customFieldProduct()
    {
        return $this->hasMany(CustomFieldProduct::class);
    }

    public function customFieldCategory()
    {
        return $this->hasMany(CustomFieldCategory::class, 'custom_field_id', 'id');
    }
}
