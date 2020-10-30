<?php

namespace App\Repositories;

use App\Model\CustomField;
use App\Repositories\Contracts\CustomFieldRepositoryInterface;

class CustomFieldRepository implements CustomFieldRepositoryInterface
{
    /**
     * Get all customFields
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return CustomField::all();
    }

    /**
     * Get single customField by id
     *
     * @param int $customFieldId
     * @return CustomField
     */
    public function find(int $customFieldId)
    {
        return CustomField::find($customFieldId);
    }

    /**
     * Get customField by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return CustomField::where($column, $value)->get();
    }
}