<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class HappyNumbers
{
    public function __construct(
        private readonly int $number
    ){}

    public function run(): bool
    {
        if ($this->number <= 0) {
            throw new InvalidArgumentException('The number cannot be less than or equal zero');
        }

        return $this->isHappy($this->number);
    }

    private function isHappy(int $number): bool
    {
        $slow = $number;
        $fast = $number;
        while(true) {
            $slow = $this->squareSum($slow);
            $fast = $this->squareSum($this->squareSum($fast));

            if (($slow !== $fast)) {
                continue;
            }
            break;
        }
        return ($slow === 1);
    }

    private function squareSum(int $number): int
    {
        $squareSum = 0;
        while ($number) {
            $squareSum += ($number % 10) * ($number % 10);
            $number = intdiv($number, 10);
        }

        return $squareSum;
    }
}
