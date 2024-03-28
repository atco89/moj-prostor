<?php

namespace App\Services;

use App\Exceptions\BadRequestException;
use App\Exceptions\DatabaseException;
use App\Exceptions\NotFoundException;
use App\Repositories\Repository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;


abstract class Service
{

    /**
     * @param Repository $repository
     */
    public function __construct(
        protected Repository $repository,
    ) {
    }

    /**
     * @param Request $request
     *
     * @return Model
     */
    abstract public function save(Request $request): Model;

    /**
     * @param array                $relations
     * @param array<string, Scope> $scopes
     *
     * @return Collection
     */
    public function findAll(array $relations = [], array $scopes = []): Collection
    {
        return $this->repository->findAll(relations: $relations, scopes: $scopes);
    }

    /**
     * @param string|null $uid
     *
     * @return void
     * @throws NotFoundException
     */
    public function delete(string|null $uid): void
    {
        $this->find(uid: $uid)->delete();
    }

    /**
     * @param string|null          $uid
     * @param array                $relations
     * @param array<string, Scope> $scopes
     *
     * @return Model|null
     * @throws NotFoundException
     */
    public function find(string|null $uid, array $relations = [], array $scopes = []): Model|null
    {
        $model = $this->repository->find(uid: $uid, relations: $relations, scopes: $scopes);
        if (empty($model)) {
            throw new NotFoundException(errors: $this->notFoundMessage());
        }
        return $model;
    }

    /**
     * @return string
     */
    abstract public function notFoundMessage(): string;

    /**
     * @param Request $request
     *
     * @return Model
     */
    abstract public function update(Request $request): Model;

    /**
     * @param Request  $request
     * @param callable $callback
     *
     * @return Model
     * @throws BadRequestException
     * @throws DatabaseException
     */
    protected function store(Request $request, callable $callback): Model
    {
        $validation = $this->validation(data: $request->all());
        if ($validation->fails()) {
            throw new BadRequestException(errors: $validation->errors());
        }

        try {
            DB::beginTransaction();
            $model = $callback($request);
            DB::commit();
            return $model;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new DatabaseException(errors: $this->saveErrorMessage(), throwable: $exception);
        }
    }

    /**
     * @param array    $data
     * @param int|null $key
     *
     * @return Validator
     */
    abstract protected function validation(array $data, int|null $key = null): Validator;

    /**
     * @return string
     */
    abstract public function saveErrorMessage(): string;

    /**
     * @param string   $param
     * @param Request  $request
     * @param callable $callback
     *
     * @return Model
     * @throws BadRequestException
     * @throws DatabaseException
     * @throws NotFoundException
     */
    protected function modify(string $param, Request $request, callable $callback): Model
    {
        $model = $this->find(uid: $request->route(param: $param));
        $validate = $this->validation(data: $request->all(), key: $model->getKey());
        if ($validate->fails()) {
            throw new BadRequestException(errors: $validate->errors());
        }

        try {
            DB::beginTransaction();
            $model = $callback($model, $request);
            DB::commit();
            return $model;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new DatabaseException(errors: $this->updateErrorMessage(), throwable: $exception);
        }
    }

    /**
     * @return string
     */
    abstract public function updateErrorMessage(): string;
}
