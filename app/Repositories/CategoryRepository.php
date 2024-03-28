<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;


class CategoryRepository extends Repository
{

    /**
     * @param array $relations
     *
     * @return Builder
     */
    protected function instance(array $relations = []): Builder
    {
        return Category::with($relations);
    }
}
