<?php

namespace App\Entity;

use App\Enum\Operation;

class Expression
{
    public int $operandOne;
    public int $operandTwo;
    public Operation $operation;
}