<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceResource;
use App\Services\SpaceService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;


class FetchAllSpacesController extends Controller
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
     *    path="/space",
     *    operationId="FetchAllSpacesController",
     *    tags={"Spaces"},
     *    summary="Fetch All Spaces.",
     *    description="Used to Fetch All Spaces.",
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent(ref="#/components/schemas/SpacesDto"),
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
        return Response::ok(resource: SpaceResource::collection(resource: $this->spaceService->findAll()));
    }
}
