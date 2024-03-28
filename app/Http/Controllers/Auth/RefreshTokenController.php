<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;


class RefreshTokenController extends Controller
{

    /**
     * @OA\Post(
     *    path="/auth/refresh",
     *    operationId="RefreshTokenController",
     *    tags={"Authentication"},
     *    summary="Refresh Token.",
     *    description="Used to Generate Refresh Token.",
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/TokenDto"),
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
    public function __invoke(): JsonResponse
    {
        $token = auth()->refresh();
        return Response::token(token: $token);
    }
}
