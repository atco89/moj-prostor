<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class SpaceResource extends JsonResource
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
            'description' => $this->description,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'numberOfReviews' => $this->number_of_reviews,
            'score' => $this->score,
            'average' => $this->average,
            'user' => new UserResource(resource: $this->user),
        ];
    }
}
