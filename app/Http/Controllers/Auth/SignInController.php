<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class SignInController extends Controller
{

    /**
     * @OA\Post(
     *    path="/auth/sign-in",
     *    operationId="SignInController",
     *    tags={"Authentication"},
     *    summary="Sign In.",
     *    description="Used to Sign In.",
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/AuthDto"),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK",
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
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->only(keys: [ 'email', 'password' ]);
        $token = auth()->attempt(credentials: $credentials);
        if (empty($token)) {
            throw new UnauthorizedException(
                errors: trans(key: 'error.Nažalost, pristup sa unetim kredencijalima nije dozvoljen. Molimo proverite svoje informacije i pokušajte ponovo.'),
            );
        }
        return Response::token(token: $token);
    }
}
