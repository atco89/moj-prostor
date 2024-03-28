<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;


class Response
{

    /**
     * @param JsonResource|Collection|null $resource
     *
     * @return JsonResponse
     */
    public static function ok(JsonResource|Collection|null $resource = null): JsonResponse
    {
        return response()->json(data: $resource);
    }

    /**
     * @param JsonResource $resource
     * @param string|null  $route
     *
     * @return JsonResponse
     */
    public static function created(JsonResource $resource, string|null $route = null): JsonResponse
    {
        $response = response()->json(data: $resource, status: 201);
        if (!empty($route)) {
            $response->header(key: 'Location', values: $route);
        }
        return $response;
    }

    /**
     * @return JsonResponse
     */
    public static function noContent(): JsonResponse
    {
        return response()->json(status: 204);
    }

    /**
     * @param string $token
     *
     * @return JsonResponse
     */
    public static function token(string $token): JsonResponse
    {
        return response()->json(data: compact(var_name: 'token'));
    }
}
