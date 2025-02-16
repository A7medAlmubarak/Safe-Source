<?php

namespace App\Exceptions\Auth;

use App\Exceptions\Base\BaseException;

class InvalidCredentialsException extends BaseException{
    protected $statusCode = 401;
    protected $errorCode = 'INVALID_CREDENTIALS';

    public function __construct($message = "Invalid email or password")
    {
        parent::__construct($message);
    }
}
