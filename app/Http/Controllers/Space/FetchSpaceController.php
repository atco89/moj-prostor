<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceResource;
use App\Services\SpaceService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class FetchSpaceController extends Controller
{

    /**
     * @param SpaceService $spaceService
     */
    public function __construct(
        private readonly SpaceService $spaceService,
    ) {
    }

    /**
     * @OA\Get(
     *    path="/space/{spaceUid}",
     *    operationId="FetchSpaceController",
     *    tags={"Spaces"},
     *    summary="Fetch Space.",
     *    description="Used to Fetch Space.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/spaceUid"
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent(ref="#/components/schemas/SpaceDto"),
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
        $spaceUid = $request->route(param: 'spaceUid');
        return Response::ok(resource: new SpaceResource(resource: $this->spaceService->find(uid: $spaceUid)));
    }
}
