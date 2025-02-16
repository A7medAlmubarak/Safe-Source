<?php

namespace App\Exceptions\File;

use App\Exceptions\Base\BaseException;

class FileNotFoundException extends BaseException
{
    protected $statusCode = 404;
    protected $errorCode = 'FILE_NOT_FOUND';

    public function __construct($message = "File not found")
    {
        parent::__construct($message);
    }
}
