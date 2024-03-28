<?php

namespace App\Observers;

use App\Models\Space;
use App\Models\SpaceReview;
use Throwable;


class SpaceReviewObserver
{

    /**
     * @param SpaceReview $review
     *
     * @return void
     * @throws Throwable
     */
    public function created(SpaceReview $review): void
    {
        $space = $review->space;
        $space
            ->set(key: 'number_of_reviews', value: $this->numberOfReviews(space: $space))
            ->set(key: 'score', value: $this->score(space: $space))
            ->set(key: 'average', value: $this->average(space: $space))
            ->updateOrFail();
    }

    /**
     * @param Space $space
     *
     * @return int
     */
    protected function numberOfReviews(Space $space): int
    {
        return $space->reviews()->count(columns: 'rate');
    }

    /**
     * @param Space $space
     *
     * @return int
     */
    protected function score(Space $space): int
    {
        return $space->reviews()->sum(column: 'rate');
    }

    /**
     * @param Space $space
     *
     * @return float
     */
    protected function average(Space $space): float
    {
        return $space->reviews()->average(column: 'rate');
    }
}
