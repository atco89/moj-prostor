<?php

namespace App\Services;

use App\Exceptions\BadRequestException;
use App\Exceptions\DatabaseException;
use App\Exceptions\NotFoundException;
use App\Models\Category;
use App\Models\Space;
use App\Models\SpaceReview;
use App\Repositories\SpaceReviewRepository;
use App\Validation\SpaceReviewValidation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;


class SpaceReviewService extends Service
{

    /**
     * @param SpaceReviewRepository $spaceReviewRepository
     * @param SpaceService          $spaceService
     * @param CategoryService       $categoryService
     * @param SpaceReviewValidation $spaceReviewValidation
     */
    public function __construct(
        SpaceReviewRepository           $spaceReviewRepository,
        protected SpaceService          $spaceService,
        protected CategoryService       $categoryService,
        protected SpaceReviewValidation $spaceReviewValidation,
    ) {
        parent::__construct(repository: $spaceReviewRepository);
    }

    /**
     * @param Request $request
     *
     * @return SpaceReview|Model
     * @throws BadRequestException
     * @throws DatabaseException
     * @throws NotFoundException
     */
    public function save(Request $request): SpaceReview|Model
    {
        $spaceUid = $request->route(param: 'spaceUid');

        /** @var Space $space */
        $space = $this->spaceService->find(uid: $spaceUid);
        /** @var Category $category */
        $category = $this->categoryService->find(uid: $request->json(key: 'category'));

        return $this->store(
            request: $request,
            callback: function (Request $request) use ($space, $category): SpaceReview {
                $review = new SpaceReview();
                $review
                    ->user()
                    ->associate(model: auth()->user());
                $review
                    ->space()
                    ->associate(model: $space);
                $review
                    ->category()
                    ->associate(model: $category);
                $review
                    ->set(key: 'rate', value: $request->json(key: 'rate'))
                    ->set(key: 'description', value: $request->json(key: 'description'))
                    ->saveOrFail();
                return $review;
            },
        );
    }

    /**
     * @param Request $request
     *
     * @return SpaceReview|Model
     * @throws BadRequestException
     * @throws DatabaseException
     * @throws NotFoundException
     */
    public function update(Request $request): SpaceReview|Model
    {
        $spaceUid = $request->route(param: 'spaceUid');

        /** @var Space $space */
        $space = $this->spaceService->find(uid: $spaceUid);
        /** @var Category $category */
        $category = $this->categoryService->find(uid: $request->json(key: 'category'));

        return $this->modify(
            param:   'spaceReviewUid',
            request: $request,
            callback: function (Request $request) use ($space, $category): SpaceReview {
                $review = new SpaceReview();
                $review
                    ->user()
                    ->associate(model: auth()->user());
                $review
                    ->space()
                    ->associate(model: $space);
                $review
                    ->category()
                    ->associate(model: $category);
                $review
                    ->set(key: 'rate', value: $request->json(key: 'rate'))
                    ->set(key: 'description', value: $request->json(key: 'description'))
                    ->updateOrFail();
                return $review;
            },
        );
    }

    /**
     * @return string
     */
    public function updateErrorMessage(): string
    {
        return trans(key: 'validation.Došlo je do greške prilikom ažuriranja ocene prostora. Pokušajte ponovo.');
    }

    /**
     * @return string
     */
    public function notFoundMessage(): string
    {
        return trans(key: 'validation.Ocena prostora nije pronađen. Proverite unos i pokušajte ponovo.');
    }

    /**
     * @return string
     */
    public function saveErrorMessage(): string
    {
        return trans(key: 'validation.Došlo je do greške prilikom ocene prostora. Molimo proverite podatke i pokušajte ponovo.');
    }

    /**
     * @param array    $data
     * @param int|null $key
     *
     * @return Validator
     */
    protected function validation(array $data, int|null $key = null): Validator
    {
        return $this->spaceReviewValidation->validation(data: $data, key: $key);
    }
}
