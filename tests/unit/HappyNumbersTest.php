<?php

declare(strict_types=1);

namespace Test\unit;

use App\HappyNumbers;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class HappyNumbersTest extends TestCase
{
    public function testShouldReturnTrue()
    {
        $happyNumber = new HappyNumbers(19);
        $isHappy = $happyNumber->run();

        $this->assertTrue($isHappy);
    }

    public function testShouldReturnFalse()
    {
        $happyNumber = new HappyNumbers(8);
        $isHappy = $happyNumber->run();

        $this->assertFalse($isHappy);
    }

    public function testCannotBeGetResultFromInvalidParams()
    {
        $this->expectException(InvalidArgumentException::class);
        $happyNumber = new HappyNumbers(-99);
        $happyNumber->run();
    }
}
