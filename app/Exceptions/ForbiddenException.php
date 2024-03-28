<?php

namespace App\Exceptions;

class ForbiddenException extends Error
{

    /**
     * @return int
     */
    protected function statusCode(): int
    {
        return 403;
    }
}
