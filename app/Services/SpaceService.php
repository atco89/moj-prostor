<?php

namespace App\Services;

use App\Exceptions\BadRequestException;
use App\Exceptions\DatabaseException;
use App\Exceptions\NotFoundException;
use App\Models\Space;
use App\Repositories\SpaceRepository;
use App\Validation\SpaceValidation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;


class SpaceService extends Service
{

    /**
     * @param SpaceRepository $spaceRepository
     * @param SpaceValidation $spaceValidation
     */
    public function __construct(
        SpaceRepository           $spaceRepository,
        protected SpaceValidation $spaceValidation,
    ) {
        parent::__construct(repository: $spaceRepository);
    }

    /**
     * @param Request $request
     *
     * @return Model
     * @throws BadRequestException
     * @throws DatabaseException
     */
    public function save(Request $request): Model
    {
        return $this->store(
            request: $request,
            callback: function (Request $request): Space {
                $space = new Space();
                $space
                    ->set(key: 'name', value: $request->json(key: 'name'))
                    ->set(key: 'description', value: $request->json(key: 'description'))
                    ->set(key: 'longitude', value: $request->json(key: 'longitude'))
                    ->set(key: 'latitude', value: $request->json(key: 'latitude'))
                    ->user()
                    ->associate(model: auth()->user())
                    ->saveOrFail();
                return $space;
            },
        );
    }

    /**
     * @return string
     */
    public function notFoundMessage(): string
    {
        return trans(key: 'validation.Prostor nije pronađen. Proverite unos i pokušajte ponovo.');
    }

    /**
     * @param Request $request
     *
     * @return Model
     * @throws BadRequestException
     * @throws DatabaseException
     * @throws NotFoundException
     */
    public function update(Request $request): Model
    {
        return $this->modify(
            param:   'spaceUid',
            request: $request,
            callback: function (Space $space, Request $request) {
                $space
                    ->set(key: 'name', value: $request->json(key: 'name'))
                    ->set(key: 'description', value: $request->json(key: 'description'))
                    ->set(key: 'longitude', value: $request->json(key: 'longitude'))
                    ->set(key: 'latitude', value: $request->json(key: 'latitude'))
                    ->user()
                    ->associate(model: auth()->user())
                    ->updateOrFail();
                return $space;
            },
        );
    }

    /**
     * @return string
     */
    public function saveErrorMessage(): string
    {
        return trans(key: 'validation.Došlo je do greške prilikom kreiranja prostora. Molimo proverite podatke i pokušajte ponovo.');
    }

    /**
     * @return string
     */
    public function updateErrorMessage(): string
    {
        return trans(key: 'validation.Došlo je do greške prilikom ažuriranja prostora. Pokušajte ponovo.');
    }

    /**
     * @param array    $data
     * @param int|null $key
     *
     * @return Validator
     */
    protected function validation(array $data, int|null $key = null): Validator
    {
        return $this->spaceValidation->validation(data: $data, key: $key);
    }
}
