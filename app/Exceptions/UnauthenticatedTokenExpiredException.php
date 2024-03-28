<?php

namespace App\Exceptions;

class UnauthenticatedTokenExpiredException extends Error
{

    /**
     * @return int
     */
    protected function statusCode(): int
    {
        return 401;
    }
}
