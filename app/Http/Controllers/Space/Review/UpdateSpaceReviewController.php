<?php

namespace App\Http\Controllers\Space\Review;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceReviewResource;
use App\Services\SpaceReviewService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UpdateSpaceReviewController extends Controller
{

    /**
     * @param SpaceReviewService $spaceReviewService
     */
    public function __construct(
        private readonly SpaceReviewService $spaceReviewService,
    ) {
    }

    /**
     * @OA\Patch(
     *    path="/space/{spaceUid}/review/{spaceReviewUid}",
     *    operationId="UpdateSpaceReviewController",
     *    tags={"SpaceReviews"},
     *    summary="Update Space Review.",
     *    description="Used to Update Space Review.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/spaceUid"
     *    ),
     *    @OA\Parameter(
     *        ref="#/components/parameters/spaceReviewUid"
     *    ),
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/SpaceDto"),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent(ref="#/components/schemas/SpaceDto"),
     *    ),
     *    @OA\Response(
     *        response=400,
     *        description="Bad Request",
     *        @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
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
     *        response=404,
     *        description="Not Found",
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
    public function __invoke(Request $request): JsonResponse
    {
        return Response::ok(
            resource: new SpaceReviewResource(resource: $this->spaceReviewService->update(request: $request)),
        );
    }
}
