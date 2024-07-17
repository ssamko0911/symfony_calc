<?php

namespace App\Exception;

class MathSignException extends AbstractException
{
    private const string ERROR_DESCRIPTOR = 'MATH_SIGN_ERROR';
    private const string MESSAGE = 'there are -, *, / and %%2B(instead +) allowed';

    public function __construct(string $errorMessage, ?\Throwable $previous = null)
    {
        $message = sprintf('%s passed: %s', $errorMessage, self::MESSAGE);
        parent::__construct($message, self::ERROR_DESCRIPTOR, $previous);
    }
}