<?php

namespace App\Http\Controllers\Space\Review;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceReviewResource;
use App\Services\SpaceReviewService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreSpaceReviewController extends Controller
{

    /**
     * @param SpaceReviewService $spaceReviewService
     */
    public function __construct(
        private readonly SpaceReviewService $spaceReviewService,
    ) {
    }

    /**
     * @OA\Post(
     *    path="/space/{spaceUid}/review",
     *    operationId="StoreSpaceReviewController",
     *    tags={"SpaceReviews"},
     *    summary="Store New Space Review.",
     *    description="Used to Store New Space Review.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/spaceUid"
     *    ),
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/SpaceReviewDto"),
     *    ),
     *    @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\Header(
     *              header="Location",
     *              description="Location of the newly created space review.",
     *              @OA\Schema(
     *                  type="string",
     *                  format="uri",
     *              ),
     *         ),
     *         @OA\JsonContent(ref="#/components/schemas/SpaceReviewDto"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *     ),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     }
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $review = $this->spaceReviewService->save(request: $request);
        return Response::created(
            resource: new SpaceReviewResource(resource: $review),
            route:    route(name: 'space.item.review.item.show', parameters: [
                          'spaceUid' => $review->space->getUid(),
                          'spaceReviewUid' => $review->getUid(),
                      ]),
        );
    }
}
