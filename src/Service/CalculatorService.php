<?php

namespace App\Service;

use App\Enum\Operation;
use App\Request\CalculatorPayloadRequest;

class CalculatorService
{
    public function calculate(CalculatorPayloadRequest $request): float
    {
        $numberOne = $request->operandOne;
        $numberTwo = $request->operandTwo;
        $mathSign = $request->operation;

        return match ($mathSign) {
            Operation::ADD => $numberOne + $numberTwo,
            Operation::SUB => $numberOne - $numberTwo,
            Operation::MUL => $numberOne * $numberTwo,
            Operation::DIV => $numberOne / $numberTwo,
        };
    }
}