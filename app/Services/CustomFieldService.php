<?php

namespace App\Services;

use App\Repositories\Contracts\CustomFieldRepositoryInterface;
use App\Repositories\Contracts\CustomFieldCategoryRepositoryInterface;

class CustomFieldService
{
    /**
     * customField repository
     *
     * @var CustomFieldRepositoryInterface $customFieldRepository
     */
    private $customFieldRepository;
    
    /**
     * customFieldCategory repository
     *
     * @var customFieldCategoryRepositoryInterface $customFieldCategoryRepository
     */
    private $customFieldCategoryRepository;

    public function __construct(
        CustomFieldRepositoryInterface $customFieldRepository,
        CustomFieldCategoryRepositoryInterface $customFieldCategoryRepository
    ) {
        $this->customFieldRepository = $customFieldRepository;
        $this->customFieldCategoryRepository = $customFieldCategoryRepository;
    }

    /**
     * Get custom fields by category
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getCustomFieldsByCategory(int $categoryId)
    {
        return $this
            ->customFieldCategoryRepository
            ->getCustomFieldsByCategory($categoryId);
    }
}