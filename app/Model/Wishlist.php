<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
