<?php

namespace App\Exceptions\File;

use App\Exceptions\Base\BaseException;

class UnauthorizedFileAccessException extends BaseException
{
    protected $statusCode = 403;
    protected $errorCode = 'UNAUTHORIZED_FILE_ACCESS';

    public function __construct($message = "You don't have permission to access this file")
    {
        parent::__construct($message);
    }
}
