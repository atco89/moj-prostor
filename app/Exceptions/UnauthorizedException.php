<?php

namespace App\Exceptions;

class UnauthorizedException extends Error
{

    /**
     * @return int
     */
    protected function statusCode(): int
    {
        return 401;
    }
}
