<?php

namespace App\Tests\App;

use App\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAddFunctionWorksAsExpected()
    {
        $calculator = new Calculator();
        $calculator->add(2);

        $this->assertSame(2, $calculator->result());
    }

    public function testMinusFunctionWorksAsExpected()
    {
        $calculator = new Calculator(4);
        $calculator->minus(2);

        $this->assertSame(2, $calculator->result());
    }
}
