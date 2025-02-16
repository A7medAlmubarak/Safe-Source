<?php

namespace App\Exceptions\File;

use App\Exceptions\Base\BaseException;

class FileAlreadyCheckedException extends BaseException
{
    protected $statusCode = 409;
    protected $errorCode = 'FILE_ALREADY_CHECKED';

    public function __construct($message = "File is already checked out by another user")
    {
        parent::__construct($message);
    }
}
