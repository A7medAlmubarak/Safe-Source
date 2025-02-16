<?php

namespace App\Exceptions\Base;

use Exception;

abstract class BaseException extends Exception
{
    protected $statusCode = 400;
    protected $errorCode = 'ERROR';

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function render()
    {
        return response()->json([
            'message' => $this->getMessage(),
            'status' => 'error',
            'error_code' => $this->getErrorCode()
        ], $this->getStatusCode());
    }
}
