<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Collection;


abstract class Repository
{

    /**
     * @param array                $relations
     * @param array<string, Scope> $scopes
     *
     * @return Collection
     */
    public function findAll(array $relations = [], array $scopes = []): Collection
    {
        $instance = $this->instance(relations: $relations);
        foreach ($scopes as $identifier => $scope) {
            $instance->withGlobalScope(identifier: $identifier, scope: $scope);
        }
        return $instance->get();
    }

    /**
     * @param array $relations
     *
     * @return Builder
     */
    abstract protected function instance(array $relations = []): Builder;

    /**
     * @param string|null          $uid
     * @param array                $relations
     * @param array<string, Scope> $scopes
     *
     * @return Model|null
     */
    public function find(string|null $uid, array $relations = [], array $scopes = []): Model|null
    {
        $instance = $this->instance(relations: $relations);
        foreach ($scopes as $identifier => $scope) {
            $instance->withGlobalScope(identifier: $identifier, scope: $scope);
        }
        return $instance->where(column: 'uid', operator: '=', value: $uid)->first();
    }
}
