<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parentID');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parentID');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'category_brand', 'category_id', 'brand_id');
    }
}
