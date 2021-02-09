<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
