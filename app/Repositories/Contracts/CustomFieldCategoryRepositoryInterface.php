<?php

namespace App\Repositories\Contracts;

use App\Model\CustomFieldCategory;

interface CustomFieldCategoryRepositoryInterface
{
    /**
     * Get all customFieldCategory
     *
     * @return Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get customFieldCategory by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     */
    public function findBy(string $column, $value);
}