<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    public static function invalidCredentials(): AppException
    {
        return new self(message: 'Please, enter a valid email and password (min 4 symbols).', code: 403);
    }
}
