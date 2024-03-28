<?php

namespace App\Http\Controllers\Space\Review;

use App\Http\Controllers\Controller;
use App\Services\SpaceReviewService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class DeleteSpaceReviewController extends Controller
{

    /**
     * @param SpaceReviewService $spaceReviewService
     */
    public function __construct(
        private readonly SpaceReviewService $spaceReviewService,
    ) {
    }

    /**
     * @OA\Delete(
     *    path="/space/{spaceUid}/review/{spaceReviewUid}",
     *    operationId="DeleteSpaceReviewController",
     *    tags={"SpaceReviews"},
     *    summary="Delete Space Review.",
     *    description="Used to Delete Space Review.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/spaceUid"
     *    ),
     *    @OA\Parameter(
     *        ref="#/components/parameters/spaceReviewUid"
     *    ),
     *    @OA\Response(
     *        response=204,
     *        description="No Content",
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
        $this->spaceReviewService->delete(uid: $request->route(param: 'spaceReviewUid'));
        return Response::noContent();
    }
}
