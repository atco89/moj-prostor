<?php

namespace App\Http\Middleware;

use App\Exceptions\ForbiddenException;
use App\Models\User;
use Closure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;


class RoleAuthorization
{

    /**
     * @param JWTAuth $auth
     */
    public function __construct(
        protected JWTAuth $auth,
    ) {
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @param string  ...$roles
     *
     * @return Response
     * @throws ForbiddenException
     * @throws JWTException
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        /** @var User $user */
        $user = $this->auth->parseToken()->authenticate();
        $this->authorize(user: $user, roles: $roles);
        return $next($request);
    }

    /**
     * @param User  $user
     * @param array $roles
     *
     * @return void
     * @throws ForbiddenException
     */
    protected function authorize(User $user, array $roles): void
    {
        if (empty($roles)) {
            return;
        }

        foreach ($user->roles as $role) {
            if (in_array(needle: $role, haystack: $roles)) {
                return;
            }
        }

        throw new ForbiddenException(
            errors: trans(key: 'error.Nemate pristup ovom resursu. Molimo vas da proverite vaša ovlašćenja.'),
        );
    }
}
