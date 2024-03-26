<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    public static function invalidCredentials(): AppException
    {
        return new self(message: 'Please, enter a valid email and password (min 4 symbols).', code: 403);
    }

    public static function passwordComparisonFailure(): AppException
    {
        return new self(message: 'Passwords didn\t match!', code: 403);
    }
}
