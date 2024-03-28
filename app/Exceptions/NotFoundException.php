<?php

namespace App\Exceptions;

class NotFoundException extends Error
{

    /**
     * @return int
     */
    protected function statusCode(): int
    {
        return 404;
    }
}
