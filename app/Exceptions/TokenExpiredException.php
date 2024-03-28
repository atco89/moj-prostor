<?php

namespace App\Exceptions;

class TokenExpiredException extends Error
{

    /**
     * @return int
     */
    protected function statusCode(): int
    {
        return 401;
    }
}
