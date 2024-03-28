<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class UserRepository extends Repository
{

    /**
     * @param array $relations
     *
     * @return Builder
     */
    protected function instance(array $relations = []): Builder
    {
        return User::with(relations: $relations);
    }
}
