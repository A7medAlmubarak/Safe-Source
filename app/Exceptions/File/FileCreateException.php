<?php

namespace App\Exceptions\File;

use App\Exceptions\Base\BaseException;

class FileCreateException extends BaseException
{
    protected $statusCode = 422;
    protected $errorCode = 'FILE_CREATE_FAILED';

    public function __construct($message = "Failed to create file record")
    {
        parent::__construct($message);
    }
}
