<?php

namespace App\Service;

use InvalidArgumentException;

class CalculatorService
{
    private function calculateAdd(int $numberOne, int $numberTwo): int
    {
        return $numberOne + $numberTwo;
    }

    private function calculateSub(int $numberOne, int $numberTwo): int
    {
        return $numberOne - $numberTwo;
    }

    private function calculateMul(int $numberOne, int $numberTwo): int
    {
        return $numberOne * $numberTwo;
    }

    private function calculateDiv(int $numberOne, int $numberTwo): int
    {
        if ($numberTwo === 0) {
            throw new InvalidArgumentException('Division by zero');
        }
        return $numberOne / $numberTwo;
    }

    public function calculate(int $numberOne, int $numberTwo, string $mathSign): int
    {
        $actionName = 'calculate' . ucfirst($mathSign);
        return $this->$actionName($numberOne, $numberTwo);
    }
}