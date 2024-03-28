<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UpdateUserController extends Controller
{

    /**
     * @param UserService $userService
     */
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    /**
     * @OA\Patch(
     *    path="/user/{userUid}",
     *    operationId="UpdateUserController",
     *    tags={"Users"},
     *    summary="Update Users.",
     *    description="Used to Update Users.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/userUid"
     *    ),
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/UserDto"),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK",
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
            resource: new UserResource(resource: $this->userService->update(request: $request)),
        );
    }
}
