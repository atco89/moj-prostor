<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class StoreCategoryController extends Controller
{

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    /**
     * @OA\Post(
     *    path="/category",
     *    operationId="StoreCategoryController",
     *    tags={"Categories"},
     *    summary="Store New Category.",
     *    description="Used to Store New Category.",
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CategoryDto"),
     *    ),
     *    @OA\Response(
     *        response=201,
     *        description="Created",
     *        @OA\Header(
     *             header="Location",
     *             description="Location of the newly created category.",
     *             @OA\Schema(
     *                 type="string",
     *                 format="uri",
     *             ),
     *        ),
     *        @OA\JsonContent(ref="#/components/schemas/CategoryDto"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorDto"),
     *     ),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     }
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $category = $this->categoryService->save(request: $request);
        $categoryUid = $category->getUid();
        return Response::created(
            resource: new CategoryResource(resource: $category),
            route:    route(name: 'category.item.show', parameters: compact(var_name: 'categoryUid')),
        );
    }
}
