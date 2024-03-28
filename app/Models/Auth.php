<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


abstract class Auth extends Base implements
    AuthenticatableContract,
    AuthorizableContract,
    MustVerifyEmail,
    CanResetPasswordContract,
    JWTSubject
{
    use Authenticatable, Authorizable, CanResetPassword, HasApiTokens;
}
