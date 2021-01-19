<?php

namespace App\Repositories;

use App\Model\Review;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use DB;
use Illuminate\Database\Query\Builder;

class ReviewRepository implements ReviewRepositoryInterface
{
    /**
     * Get all reviews
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return Review::all();
    }

    /**
     * Get single review by id
     *
     * @param int $reviewId
     * @return Review
     */
    public function find(int $reviewId)
    {
        return Review::find($reviewId);
    }

    /**
     * Get review by column
     *
     * @param string $column
     * @param mixed $value
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function findBy(string $column, $value)
    {
        return Review::where($column, $value)->get();
    }

    /**
     * Get reviews by product
     *
     * @param int $productId
     * @return Illuminate\Support\Collection
     * @throws QueryException
     */
    public function getReviewsByProduct(int $productId)
    {
        return  Review::where('product_id', $productId)
            ->orderBy('id', 'desc')
            ->get();
    }
}