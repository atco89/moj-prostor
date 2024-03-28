<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;


class OwnedByUserScope implements Scope
{

    /**
     * @param Builder $builder
     * @param Model   $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(column: 'user_id', operator: '=', value: auth()->user()->getAuthIdentifier());
    }
}
