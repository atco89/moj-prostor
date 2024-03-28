<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use App\Services\SpaceService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class DeleteSpaceController extends Controller
{

    /**
     * @param SpaceService $spaceService
     */
    public function __construct(
        private readonly SpaceService $spaceService,
    ) {
    }

    /**
     * @OA\Delete(
     *    path="/space/{spaceUid}",
     *    operationId="DeleteSpaceController",
     *    tags={"Spaces"},
     *    summary="Delete Space.",
     *    description="Used to Delete Space.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/spaceUid"
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
        $this->spaceService->delete(uid: $request->route(param: 'spaceUid'));
        return Response::noContent();
    }
}
