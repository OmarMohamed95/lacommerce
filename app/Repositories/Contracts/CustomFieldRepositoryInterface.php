<?php

namespace App\Repositories\Contracts;

use App\Model\CustomField;

interface CustomFieldRepositoryInterface
{
    /**
     * Get all customField
     *
     * @return Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get single customField by id
     *
     * @param int $customFieldId
     * @return CustomField
     */
    public function find(int $customFieldId);

    /**
     * Get customField by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     */
    public function findBy(string $column, $value);
}