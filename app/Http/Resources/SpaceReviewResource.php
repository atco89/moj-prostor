<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class SpaceReviewResource extends JsonResource
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
            'user' => new UserResource(resource: $this->user),
            'space' => new SpaceResource(resource: $this->space),
            'rate' => $this->rate,
            'description' => $this->description,
        ];
    }
}
