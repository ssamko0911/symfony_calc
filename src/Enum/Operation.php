<?php

namespace App\Enum;

enum Operation: string
{
    case ADD = '+';
    case SUB = '-';
    case MUL = '*';
    case DIV = '/';
}
