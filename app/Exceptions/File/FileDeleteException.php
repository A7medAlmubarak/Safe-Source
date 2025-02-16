<?php

namespace App\Exceptions\File;

use App\Exceptions\Base\BaseException;

class FileDeleteException extends BaseException
{
    protected $statusCode = 422;
    protected $errorCode = 'FILE_DELETE_FAILED';

    public function __construct($message = "Failed to delete file")
    {
        parent::__construct($message);
    }
}
