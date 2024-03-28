<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class FetchUserController extends Controller
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
     *    path="/user/{userUid}",
     *    operationId="FetchUserController",
     *    tags={"Users"},
     *    summary="Fetch User.",
     *    description="Used to Fetch User.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/userUid"
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent(ref="#/components/schemas/UserDto"),
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
        $userUid = $request->route(param: 'userUid');
        return Response::ok(resource: new UserResource(resource: $this->userService->find(uid: $userUid)));
    }
}
