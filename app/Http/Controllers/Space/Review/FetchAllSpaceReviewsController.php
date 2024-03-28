<?php

namespace App\Http\Controllers\Space\Review;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceReviewResource;
use App\Services\SpaceReviewService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;


class FetchAllSpaceReviewsController extends Controller
{

    /**
     * @param SpaceReviewService $spaceReviewService
     */
    public function __construct(
        private readonly SpaceReviewService $spaceReviewService,
    ) {
    }

    /**
     * @OA\Get(
     *    path="/space/{spaceUid}/review",
     *    operationId="FetchAllSpaceReviewsController",
     *    tags={"SpaceReviews"},
     *    summary="Fetch All Space Reviews.",
     *    description="Used to Fetch All Space Reviews.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/spaceUid"
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent(ref="#/components/schemas/SpaceReviewsDto"),
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *        @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *    ),
     *    @OA\Response(
     *        response=403,
     *        description="Forbidden",
     *        @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *    ),
     *    @OA\Response(
     *        response=500,
     *        description="Internal Server Error",
     *        @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *    ),
     *    security={
     *        {
     *            "bearerAuth": {}
     *        }
     *    }
     * )
     */
    public function __invoke(): JsonResponse
    {
        return Response::ok(resource: SpaceReviewResource::collection(resource: $this->spaceReviewService->findAll()));
    }
}
