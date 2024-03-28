<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceResource;
use App\Models\Space;
use App\Services\SpaceService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreSpaceController extends Controller
{

    /**
     * @param SpaceService $spaceService
     */
    public function __construct(
        private readonly SpaceService $spaceService,
    ) {
    }

    /**
     * @OA\Post(
     *    path="/space",
     *    operationId="StoreSpaceController",
     *    tags={"Spaces"},
     *    summary="Store New Space.",
     *    description="Used to Store New Space.",
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/SpaceDto"),
     *    ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\Header(
     *              header="Location",
     *              description="Location of the newly created space.",
     *              @OA\Schema(
     *                  type="string",
     *                  format="uri",
     *              ),
     *         ),
     *         @OA\JsonContent(ref="#/components/schemas/SpaceDto"),
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
     *  )
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var Space $space */
        $space = $this->spaceService->save(request: $request);
        $spaceUid = $space->getUid();
        return Response::created(
            resource: new SpaceResource(resource: $space),
            route:    route(name: 'space.item.show', parameters: compact(var_name: 'spaceUid')),
        );
    }
}
