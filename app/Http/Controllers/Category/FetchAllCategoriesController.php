<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class FetchAllCategoriesController extends Controller
{

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    /**
     * @OA\Get(
     *    path="/category",
     *    operationId="FetchAllCategoriesController",
     *    tags={"Categories"},
     *    summary="Fetch All Categories.",
     *    description="Used to Fetch All Categories.",
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent(ref="#/components/schemas/CategoriesDto"),
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
        $categories = $this->categoryService->findAll();
        return Response::ok(resource: CategoryResource::collection(resource: $categories));
    }
}
