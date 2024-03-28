<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class DeleteUserController extends Controller
{

    /**
     * @param UserService $userService
     */
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    /**
     * @OA\Delete(
     *    path="/user/{userUid}",
     *    operationId="DeleteUserController",
     *    tags={"Users"},
     *    summary="Delete User.",
     *    description="Used to Delete User.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/userUid"
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
        $this->userService->delete(uid: $request->route(param: 'userUid'));
        return Response::noContent();
    }
}
