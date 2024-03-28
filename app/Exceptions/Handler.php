<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class Handler extends ExceptionHandler
{

    /**
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param           $request
     * @param Throwable $e
     *
     * @return JsonResponse|RedirectResponse|Response
     * @throws Throwable
     * @throws TokenExpiredException
     */
    public function render($request, Throwable $e): JsonResponse|RedirectResponse|Response
    {
        if ($e instanceof TokenInvalidException) {
            throw new UnauthenticatedInvalidTokenException(
                errors:    trans(key: 'error.Vaš token je nevažeći. Molimo vas da proverite vaše podatke i pokušajte ponovo.'),
                throwable: $e,
            );
        }

        if ($e instanceof TokenExpiredException) {
            throw new UnauthenticatedTokenExpiredException(
                errors:    trans(key: 'error.Vaš token je istekao. Molimo vas da se ponovo prijavite.'),
                throwable: $e,
            );
        }

        if ($e instanceof JWTException) {
            throw new TokenException(
                errors:    trans(key: 'error.Došlo je do greške prilikom obrade vašeg tokena. Molimo vas da kontaktirate podršku.'),
                throwable: $e,
            );
        }

        return parent::render($request, $e);
    }
}
