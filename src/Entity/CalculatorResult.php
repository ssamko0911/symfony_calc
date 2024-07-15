<?php

namespace App\Entity;

class CalculatorResult
{
    private int $result;

    /**
     * @param int $result
     */
    public function __construct(int $result)
    {
        $this->result = $result;
    }


    public function getResult(): int
    {
        return $this->result;
    }

    public function setResult(int $result): void
    {
        $this->result = $result;
    }
}