<?php

namespace App\Exception;

use Exception;

class  AbstractException extends Exception
{
    private string $errorCode;

    public function __construct(string $message, string $errorCode, ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->errorCode = $errorCode;
    }
}