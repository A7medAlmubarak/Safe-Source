<?php

namespace App\Exceptions\File;

use App\Exceptions\Base\BaseException;

class FileUploadException extends BaseException
{
    protected $statusCode = 422;
    protected $errorCode = 'FILE_UPLOAD_FAILED';

    public function __construct($message = "File upload failed")
    {
        parent::__construct($message);
    }
}
