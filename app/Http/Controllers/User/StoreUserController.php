<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreUserController extends Controller
{

    /**
     * @param UserService $userService
     */
    public function __construct(private readonly UserService $userService,)
    {
    }

    /**
     * @OA\Post(
     *    path="/user",
     *    operationId="StoreUserController",
     *    tags={"Users"},
     *    summary="Store New User.",
     *    description="Used to Store New User.",
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/UserDto"),
     *    ),
     *    @OA\Response(
     *        response=201,
     *        description="Created",
     *        @OA\Header(
     *             header="Location",
     *             description="Location of the newly created user.",
     *             @OA\Schema(
     *                 type="string",
     *                 format="uri",
     *             ),
     *        ),
     *        @OA\JsonContent(ref="#/components/schemas/UserDto"),
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
        $user = $this->userService->save(request: $request);
        $userUid = $user->getUid();
        return Response::created(
            resource: new UserResource(resource: $user),
            route:    route(name: 'user.item.show', parameters: compact(var_name: 'userUid')),
        );
    }
}
