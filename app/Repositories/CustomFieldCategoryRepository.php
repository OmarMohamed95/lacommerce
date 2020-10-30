<?php

namespace App\Repositories;

use App\Model\CustomFieldCategory;
use App\Repositories\Contracts\CustomFieldCategoryRepositoryInterface;

class CustomFieldCategoryRepository implements CustomFieldCategoryRepositoryInterface
{
    /**
     * Get all customFieldCategory
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return CustomFieldCategory::all();
    }

    /**
     * Get customFieldCategory by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return CustomFieldCategory::where($column, $value)->get();
    }

    /**
     * Get custom fields by category ID
     *
     * @param int $categoryId
     * @return Illuminate\Support\Collection
     */
    public function getCustomFieldsByCategory(int $categoryId)
    {
        return CustomFieldCategory::from('custom_field_categories AS cfc')
            ->join('custom_fields AS cf', 'cfc.custom_field_id', '=', 'cf.id')
            ->where('cf.show_in_filter', true)
            ->where('cfc.category_id', $categoryId)
            ->get();
    }
}