<?php

namespace App\Request;

use App\Enum\Operation;
use Symfony\Component\Validator\Constraints as Assert;

// This object is called DTO data transfer object ???
final class CalculatorPayloadRequest
{
    #[Assert\NotNull]
    public int $operandOne;

    #[Assert\NotNull]
    public int $operandTwo;

    #[Assert\Choice(choices: [
        Operation::MUL,
        Operation::DIV,
        Operation::SUB,
        Operation::ADD])
    ]
    public Operation $operation;
}