<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;


class FetchAllUsersController extends Controller
{

    /**
     * @param UserService $userService
     */
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    /**
     * @OA\Get(
     *    path="/user",
     *    operationId="FetchAllUsersController",
     *    tags={"Users"},
     *    summary="Fetch All Users.",
     *    description="Used to Fetch All Users.",
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent(ref="#/components/schemas/UsersDto"),
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
        $users = $this->userService->findAll();
        return Response::ok(resource: UserResource::collection(resource: $users));
    }
}
