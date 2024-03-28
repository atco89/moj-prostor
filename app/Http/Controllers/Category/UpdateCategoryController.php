<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UpdateCategoryController extends Controller
{

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    /**
     * @OA\Patch(
     *    path="/category/{categoryUid}",
     *    operationId="UpdateCategoryController",
     *    tags={"Categories"},
     *    summary="Update Category.",
     *    description="Used to Update Category.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/categoryUid"
     *    ),
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CategoryDto"),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent(ref="#/components/schemas/CategoryDto"),
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
        $categoryResource = new CategoryResource(resource: $this->categoryService->update(request: $request));
        return Response::ok(resource: $categoryResource);
    }
}
