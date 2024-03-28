<?php

namespace App\Exceptions;

class BadRequestException extends Error
{

    /**
     * @return int
     */
    protected function statusCode(): int
    {
        return 400;
    }
}
