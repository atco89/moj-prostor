<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class DeleteCategoryController extends Controller
{

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    /**
     * @OA\Delete(
     *    path="/category/{categoryUid}",
     *    operationId="DeleteCategoryController",
     *    tags={"Categories"},
     *    summary="Delete Category.",
     *    description="Used to Delete Category.",
     *    @OA\Parameter(
     *        ref="#/components/parameters/categoryUid"
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
        $this->categoryService->delete(uid: $request->route(param: 'categoryUid'));
        return Response::noContent();
    }
}
