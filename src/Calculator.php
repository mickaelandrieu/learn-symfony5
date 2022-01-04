<?php

namespace App;

/**
 * This class is used to realize some basic calculations.
 * For training purposes only, use bc_math functions instead.
 *
 * @author Mickaël Andrieu <mickael.andrieu@solvolabs.com>
 */
class Calculator
{
    /**
     * @var float the result to display
     */
    private $result;

    /**
     * Creates the Calculator.
     *
     * @param float $initialValue
     */
    public function __construct($initialValue = 0)
    {
        $this->result = $initialValue;
    }

    public function add(float $number): void
    {
        $this->result = $this->result + $number;
    }

    public function minus(float $number): void
    {
        $this->result = $this->result - $number;
    }

    public function multiply(float $number): void
    {
        $this->result = $this->result * $number;
    }

    public function divideBy(float $number): void
    {
        $this->result = $this->result / $number;
    }

    public function result(): string
    {
        return (string) $this->result;
    }
}
