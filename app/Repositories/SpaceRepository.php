<?php

namespace App\Repositories;

use App\Models\Space;
use Illuminate\Database\Eloquent\Builder;


class SpaceRepository extends Repository
{

    /**
     * @param array $relations
     *
     * @return Builder
     */
    protected function instance(array $relations = []): Builder
    {
        return Space::with(relations: $relations);
    }
}
