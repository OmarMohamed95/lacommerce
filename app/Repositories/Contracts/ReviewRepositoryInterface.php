<?php

namespace App\Repositories\Contracts;

use App\Model\Review;

interface ReviewRepositoryInterface
{
    /**
     * Get all reviews
     *
     * @return Illuminate\Support\Collection
     */
    public function all();

    /**
     * Get single review by id
     *
     * @param int $reviewId
     * @return Review
     */
    public function find(int $reviewId);

    /**
     * Get review by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     */
    public function findBy(string $column, $value);
}