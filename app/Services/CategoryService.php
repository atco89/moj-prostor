<?php

namespace App\Services;

use App\Exceptions\BadRequestException;
use App\Exceptions\DatabaseException;
use App\Exceptions\NotFoundException;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Validation\CategoryValidation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator as v;


class CategoryService extends Service
{

    /**
     * @param CategoryRepository $categoryRepository
     * @param CategoryValidation $categoryValidation
     */
    public function __construct(
        CategoryRepository           $categoryRepository,
        protected CategoryValidation $categoryValidation,
    ) {
        parent::__construct(repository: $categoryRepository);
    }

    /**
     * @param Request $request
     *
     * @return Category|Model
     * @throws BadRequestException
     * @throws DatabaseException
     */
    public function save(Request $request): Category|Model
    {
        return $this->store(
            request: $request,
            callback: function (Request $request): Category|Model {
                $category = new Category();
                $category
                    ->set(key: 'name', value: $request->json(key: 'name'))
                    ->saveOrFail();
                return $category;
            },
        );
    }

    /**
     * @return string
     */
    public function saveErrorMessage(): string
    {
        return trans(key: 'validation.Došlo je do greške prilikom čuvanja kategorije. Molimo proverite podatke i pokušajte ponovo.');
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
            param:   'categoryUid',
            request: $request,
            callback: function (Category|Model $category, Request $request) {
                $category
                    ->set(key: 'name', value: $request->json(key: 'name'))
                    ->updateOrFail();
                return $category;
            },
        );
    }

    /**
     * @return string
     */
    public function updateErrorMessage(): string
    {
        return trans(key: 'validation.Došlo je do greške prilikom ažuriranja kategorije. Pokušajte ponovo.');
    }

    /**
     * @return string
     */
    public function notFoundMessage(): string
    {
        return trans(key: 'validation.Kategorija nije pronađena. Proverite unos i pokušajte ponovo.');
    }

    /**
     * @param array    $data
     * @param int|null $key
     *
     * @return v
     */
    protected function validation(array $data, int|null $key = null): v
    {
        return $this->categoryValidation->validation(data: $data, key: $key);
    }
}
