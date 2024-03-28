<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;


class SignOutController extends Controller
{

    /**
     * @OA\Post(
     *    path="/auth/sign-out",
     *    operationId="SignOutController",
     *    tags={"Authentication"},
     *    summary="Sign Out.",
     *    description="Used to Sign Out.",
     *    @OA\Response(
     *        response=200,
     *        description="OK",
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
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        auth()->logout();
        return Response::ok();
    }
}
