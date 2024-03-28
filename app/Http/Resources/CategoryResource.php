<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class CategoryResource extends JsonResource
{

    /**
     * @param Request $request
     *
     * @return array
     * @noinspection PhpUndefinedFieldInspection
     */
    public function toArray(Request $request): array
    {
        return [
            'uid' => $this->uid,
            'name' => $this->name,
            'numberOfReviews' => $this->when(
                condition: $request->query(key: 'numberOfReviews'),
                value:     $this->reviews->count(),
            ),
            'reviews' => $this->when(
                condition: $request->query(key: 'reviews'),
                value:     SpaceReviewResource::collection(resource: $this->reviews),
            ),
        ];
    }
}
