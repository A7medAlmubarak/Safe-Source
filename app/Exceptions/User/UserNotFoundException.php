<?php

namespace App\Exceptions\User;

use App\Exceptions\Base\BaseException;

class UserNotFoundException extends BaseException
{
    protected $statusCode = 404;
    protected $errorCode = 'USER_NOT_FOUND';

    public function __construct($message = "User not found")
    {
        parent::__construct($message);
    }
}
