<?php

namespace App\Exceptions;

class UnauthenticatedInvalidTokenException extends Error
{

    /**
     * @return int
     */
    protected function statusCode(): int
    {
        return 401;
    }
}
