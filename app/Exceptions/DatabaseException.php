<?php

namespace App\Exceptions;

class DatabaseException extends Error
{

    /**
     * @return int
     */
    protected function statusCode(): int
    {
        return 500;
    }
}
