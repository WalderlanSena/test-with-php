<?php

declare(strict_types=1);

namespace Test\unit;

use App\SumMultipleNaturalNumber;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

final class SumMultipleNaturalNumberTest extends TestCase
{
    const string AND_OPERATOR = '&&';
    const string OR_OPERATOR = '||';
    const int TERM_ONE = 3;
    const int TERM_TWO = 5;
    const int TERM_THREE = 7;
    const int START = 0;
    const int END = 1000;
    const int START_GREATER_THEN_END = 2000;
    const int INVALID_START = -45;
    const int INVALID_END = -456;
    const int SUM_MULTIPLES_3_OR_5 = 233168;
    const int SUM_MULTIPLES_3_AND_5 = 33165;
    const int SUM_MULTIPLES_3_OR_5_AND_7 = 33173;

    public function testCanBeGetResultFromValidParams()
    {
        $sumMultipleNaturalNumber = new SumMultipleNaturalNumber(
            self::AND_OPERATOR,
            self::START,
            self::END,
            self::TERM_ONE,
            self::TERM_TWO,
        );

        $this->assertInstanceOf(SumMultipleNaturalNumber::class, $sumMultipleNaturalNumber);
    }

    public function testCannotGetResultFromInvalidParameters()
    {
        $this->expectException(InvalidArgumentException::class);
        new SumMultipleNaturalNumber(
            self::AND_OPERATOR,
            self::INVALID_START,
            self::INVALID_END,
            self::TERM_ONE,
            self::TERM_TWO,
        );
    }

    public function testCannotGetResultFromStartGreaterThenEnd()
    {
        $this->expectException(InvalidArgumentException::class);
        new SumMultipleNaturalNumber(
            self::AND_OPERATOR,
            self::START_GREATER_THEN_END,
            self::END,
            self::TERM_ONE,
            self::TERM_TWO,
        );
    }

    public function testCanBeReturnSumOfThreeAndFiveParam(): void
    {
        $sumMultipleNaturalNumber = new SumMultipleNaturalNumber(
            self::OR_OPERATOR,
            self::START,
            self::END,
            self::TERM_ONE,
            self::TERM_TWO,
        );

        $sumBetweenTwoTerm = $sumMultipleNaturalNumber->getResult();

        $this->assertEquals(self::SUM_MULTIPLES_3_OR_5, $sumBetweenTwoTerm);
    }

    public function testCanBeReturnSumOfThreeOrFiveParam(): void
    {
        $sumMultipleNaturalNumber = new SumMultipleNaturalNumber(
            self::OR_OPERATOR,
            self::START,
            self::END,
            self::TERM_ONE,
            self::TERM_TWO,
        );

        $sumBetweenTwoTerm = $sumMultipleNaturalNumber->getResult();

        $this->assertEquals(self::SUM_MULTIPLES_3_OR_5, $sumBetweenTwoTerm);
    }

    public function testCanBeReturnSumOfThreeOrFiveAndSevenParam(): void
    {
        $sumMultipleNaturalNumber = new SumMultipleNaturalNumber(
            self::OR_OPERATOR,
            self::START,
            self::END,
            self::TERM_ONE,
            self::TERM_TWO,
            self::TERM_THREE,
        );

        $sumBetweenTwoTerm = $sumMultipleNaturalNumber->getResult();

        $this->assertEquals(self::SUM_MULTIPLES_3_OR_5_AND_7, $sumBetweenTwoTerm);
    }
}
