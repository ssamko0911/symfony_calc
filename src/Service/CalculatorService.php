<?php

namespace App\Service;

use InvalidArgumentException;

class CalculatorService
{
    public static function calculate($numberOne, $numberTwo): int
    {
        if ($numberTwo === 0) {
            throw new InvalidArgumentException('Division by zero');
        }
        return $numberOne / $numberTwo;
    }
}