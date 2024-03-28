<?php

namespace App\Exceptions;

class TokenException extends Error
{

    /**
     * @return int
     */
    protected function statusCode(): int
    {
        return 401;
    }
}
