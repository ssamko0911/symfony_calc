<?php

namespace App\Service;

use App\Entity\CalculatorResult;
use App\Enum\Operation;

class CalculatorService
{
    public function calculate(int $numberOne, int $numberTwo, Operation $mathSign): CalculatorResult
    {
        $result = match ($mathSign) {
            Operation::ADD => $numberOne + $numberTwo,
            Operation::SUB => $numberOne - $numberTwo,
            Operation::MUL => $numberOne * $numberTwo,
            Operation::DIV => $numberOne / $numberTwo,
            default => 0,
        };

        return new CalculatorResult($result);
    }
}