<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceResource;
use App\Services\SpaceService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UpdateSpaceController extends Controller
{

    /**
     * @param SpaceService $spaceService
     */
    public function __construct(
        private readonly SpaceService $spaceService,
    ) {
    }

    /**
     * @OA\Patch(
     *    path="/space/{spaceUid}",
     *    operationId="UpdateSpaceController",
     *    tags={"Spaces"},
     *    summary="Edit Space.",
     *    description="Used to Edit Space.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/spaceUid"
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
        return Response::ok(resource: new SpaceResource(resource: $this->spaceService->update(request: $request)));
    }
}
