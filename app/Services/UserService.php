<?php

namespace App\Services;

use App\Exceptions\BadRequestException;
use App\Exceptions\DatabaseException;
use App\Exceptions\NotFoundException;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Validation\UserValidation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;


class UserService extends Service
{

    /**
     * @var string[]
     */
    const ROLES = [ Role::USER, Role::OWNER ];

    /**
     * @param UserRepository $userRepository
     * @param UserValidation $userValidation
     */
    public function __construct(
        UserRepository           $userRepository,
        protected UserValidation $userValidation,
    ) {
        parent::__construct(repository: $userRepository);
    }

    /**
     * @param Request $request
     *
     * @return User|Model
     * @throws BadRequestException
     * @throws DatabaseException
     */
    public function save(Request $request): User|Model
    {
        return $this->store(
            request: $request,
            callback: function (Request $request): User {
                $user = new User();
                $user
                    ->set(key: 'name', value: $request->json(key: 'name'))
                    ->set(key: 'email', value: $request->json(key: 'email'))
                    ->set(key: 'password', value: Hash::make(value: $request->json(key: 'password')))
                    ->set(key: 'roles', value: auth()->guest() ? static::ROLES : $request->json(key: 'roles'));

                $user->saveOrFail();
                event(new Registered(user: $user));
                return $user;
            },
        );
    }

    /**
     * @return string
     */
    public function saveErrorMessage(): string
    {
        return trans(key: 'validation.Došlo je do greške prilikom kreiranja profila korisnika. Molimo proverite podatke i pokušajte ponovo.');
    }

    /**
     * @param Request $request
     *
     * @return User|Model
     * @throws BadRequestException
     * @throws DatabaseException
     * @throws NotFoundException
     */
    public function update(Request $request): User|Model
    {
        return $this->modify(
            param:   'userUid',
            request: $request,
            callback: function (User $user, Request $request): User {
                $password = $request->json(key: 'password');
                if (!empty($password)) {
                    $user->set(key: 'password', value: Hash::make(value: $password));
                }

                $user
                    ->set(key: 'name', value: $request->json(key: 'name'))
                    ->set(key: 'email', value: $request->json(key: 'email'))
                    ->set(key: 'roles', value: auth()->guest() ? static::ROLES : $request->json(key: 'roles'));

                $user->updateOrFail();
                return $user;
            },
        );
    }

    /**
     * @return string
     */
    public function notFoundMessage(): string
    {
        return trans(key: 'validation.Korisnik nije pronađen. Proverite unos i pokušajte ponovo.');
    }

    /**
     * @return string
     */
    public function updateErrorMessage(): string
    {
        return trans(key: 'validation.Došlo je do greške prilikom ažuriranja profila korisnika. Pokušajte ponovo.');
    }

    /**
     * @param array    $data
     * @param int|null $key
     *
     * @return Validator
     */
    protected function validation(array $data, int|null $key = null): Validator
    {
        return $this->userValidation->validation(data: $data, key: $key);
    }
}
