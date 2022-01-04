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

    /**
     * @param float $number a number
     */
    public function add($number)
    {
        $this->result = $this->result + $number;
    }

    /**
     * @param float $number a number
     */
    public function minus($number)
    {
        $this->result = $this->result - $number;
    }

    /**
     * @param float $number a number
     */
    public function multiply($number)
    {
        $this->result = $this->result * $number;
    }

    /**
     * @param float $number a number
     */
    public function divideBy($number)
    {
        $this->result = $this->result / $number;
    }

    /**
     * If the object is returned, the result should be displayed.
     *
     * @return string
     */
    public function result()
    {
        return $this->result;
    }
}
