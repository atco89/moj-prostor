<?php

namespace App\Repositories;

use App\Models\SpaceReview;
use Illuminate\Database\Eloquent\Builder;


class SpaceReviewRepository extends Repository
{

    /**
     * @param array $relations
     *
     * @return Builder
     */
    protected function instance(array $relations = []): Builder
    {
        return SpaceReview::with(relations: $relations);
    }
}
