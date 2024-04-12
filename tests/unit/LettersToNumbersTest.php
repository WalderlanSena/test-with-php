<?php

use App\LettersToNumbers;
use PHPUnit\Framework\TestCase;

final class LettersToNumbersTest extends TestCase
{
    public function testCanBeResultIsArray()
    {
        $letters = new LettersToNumbers('test letters');
        $answer = $letters->run();
        $this->assertIsArray($answer);
    }

    public function testCannotBeGetResultFromInvalidParams()
    {
        $this->expectException(InvalidArgumentException::class);
        $letters = new LettersToNumbers(null);
        $letters->run();
    }
}

