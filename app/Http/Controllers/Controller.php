<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Moj Prostor API",
 *      description="Moj Prostor je aplikacija koja omogućava pronalaženje različitih prostora i označavanje istih na Google mapi, kako bi ih drugi korisnici mogli pregledati i oceniti.",
 *      termsOfService="https://moj-prostor.rs/uslovi-koriscenja",
 *      @OA\Contact(
 *          name="Support",
 *          email="api@moj-prostor.rs",
 *      ),
 * )
 *
 * @OA\SecurityScheme(
 *      type="http",
 *      name="bearerAuth",
 *      in="header",
 *      bearerFormat="JWT",
 *      scheme="bearer",
 *      securityScheme="bearerAuth",
 * )
 *
 * @OA\Schema(
 *      schema="UserDto",
 *      title="User",
 *      @OA\Property(
 *          property="uid",
 *          type="string",
 *          format="uuid",
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          format="email",
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          format="password",
 *      ),
 *      required={
 *          "name",
 *          "email",
 *          "password",
 *      }
 * )
 *
 * @OA\Schema(
 *      schema="AuthDto",
 *      title="Auth",
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          format="email",
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          format="password",
 *      ),
 *      required={
 *          "email",
 *          "password",
 *      }
 * )
 *
 * @OA\Schema(
 *      schema="TokenDto",
 *      title="Token",
 *      @OA\Property(
 *          property="token",
 *          type="string",
 *          format="email",
 *      ),
 *      required={
 *          "token",
 *      }
 * )
 *
 * @OA\Schema(
 *      schema="UsersDto",
 *      title="Users",
 *      type="array",
 *      @OA\Items(ref="#/components/schemas/UserDto"),
 * )
 *
 * @OA\Schema(
 *      schema="CategoryDto",
 *      title="Category",
 *      @OA\Property(
 *          property="uid",
 *          type="string",
 *          format="uuid",
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="numberOfReviews",
 *          type="int",
 *          format="int32",
 *      ),
 *      required={
 *          "name",
 *      }
 * )
 *
 * @OA\Schema(
 *      schema="CategoriesDto",
 *      title="Categories",
 *      type="array",
 *      @OA\Items(ref="#/components/schemas/CategoryDto"),
 * )
 *
 * @OA\Schema(
 *      schema="SpaceDto",
 *      title="Space",
 *      type="object",
 *      @OA\Property(
 *          property="uid",
 *          type="string",
 *          format="uuid",
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="longitude",
 *          type="number",
 *          format="double",
 *      ),
 *      @OA\Property(
 *          property="latitude",
 *          type="number",
 *          format="double",
 *      ),
 *      @OA\Property(
 *          property="numberOfReviews",
 *          type="int",
 *          format="int32",
 *      ),
 *      @OA\Property(
 *          property="score",
 *          type="int",
 *          format="int32",
 *      ),
 *      @OA\Property(
 *          property="average",
 *          type="number",
 *          format="double",
 *      ),
 *      required={
 *          "name",
 *          "longitude",
 *          "latitude",
 *      }
 * )
 *
 * @OA\Schema(
 *      schema="SpacesDto",
 *      title="Spaces",
 *      type="array",
 *      @OA\Items(ref="#/components/schemas/SpaceDto"),
 * )
 *
 * @OA\Schema(
 *      schema="SpaceReviewDto",
 *      title="SpaceReview",
 *      type="object",
 *      @OA\Property(
 *          property="uid",
 *          type="string",
 *          format="uuid",
 *      ),
 *      @OA\Property(
 *          property="user",
 *          ref="#/components/schemas/UserDto"
 *      ),
 *      @OA\Property(
 *          property="space",
 *          ref="#/components/schemas/SpaceDto"
 *      ),
 *      @OA\Property(
 *          property="category",
 *          ref="#/components/schemas/CategoryDto"
 *      ),
 *      @OA\Property(
 *          property="rate",
 *          type="int",
 *          format="int32",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *      ),
 *      required={
 *          "category",
 *          "rate",
 *      }
 * )
 *
 * @OA\Schema(
 *      schema="SpaceReviewsDto",
 *      title="SpaceReviews",
 *      type="array",
 *      @OA\Items(ref="#/components/schemas/SpaceReviewDto"),
 * )
 *
 * @OA\Schema(
 *      schema="ErrorDto",
 *      title="Error",
 *      @OA\Property(
 *          property="cid",
 *          type="string",
 *          format="uuid",
 *      ),
 *      @OA\Property(
 *          property="timestamp",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string"
 *      ),
 *      required={
 *          "cid",
 *          "timestamp",
 *          "message",
 *      }
 * )
 *
 * @OA\Parameter(
 *     name="categoryUid",
 *     in="path",
 *     required=true,
 *     description="Used to identify category.",
 *     @OA\Schema(
 *          type="string",
 *          format="uuid",
 *     )
 * )
 *
 * @OA\Parameter(
 *     name="spaceUid",
 *     in="path",
 *     required=true,
 *     description="Used to identify space.",
 *     @OA\Schema(
 *          type="string",
 *          format="uuid",
 *     )
 * )
 *
 * @OA\Parameter(
 *     name="spaceReviewUid",
 *     in="path",
 *     required=true,
 *     description="Used to identify space review.",
 *     @OA\Schema(
 *          type="string",
 *          format="uuid",
 *     )
 * )
 *
 * @OA\Parameter(
 *     name="userUid",
 *     in="path",
 *     required=true,
 *     description="Used to identify user.",
 *     @OA\Schema(
 *          type="string",
 *          format="uuid",
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
