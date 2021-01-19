<?php

namespace App\Services;

use App\Model\Review;
use App\Repositories\Contracts\ReviewRepositoryInterface;

class ReviewService
{
    /**
     * Review repository
     *
     * @var ReviewRepositoryInterface $reviewRepository
     */
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Get reviews for product page
     *
     * @param int $productId
     * @return Illuminate\Support\Collection
     */
    public function getReviewForProductPage(int $productId)
    {
        return $this->reviewRepository->getReviewsByProduct($productId);
    }
}