<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class SumMultipleNaturalNumber
{
    public function __construct(
        private readonly string $operator,
        private readonly int $start,
        private readonly int $end,
        private readonly int $termOne,
        private readonly int $termTwo,
        private readonly ?int $termThree = null,
    ){
        $this->validateRangeParams();
    }

    private function validateRangeParams(): void
    {
        if ($this->start < 0) {
            throw new InvalidArgumentException('The start value can not be less then zero.');
        }

        if ($this->start > 0) {
            throw new InvalidArgumentException('The start value can not be greater then end value.');
        }
    }

    public function getResult(): int
    {
        $total = 0;
        for ($range = $this->start; $range < $this->end; $range++) {
            if (!is_null($this->termThree)) {
                $this->sumAllParameters($total, $range);
                continue;
            }
            $this->sumRequiredParams($total, $range);
        }

        return $total;
    }

    private function sumRequiredParams(int &$total, int &$range): void
    {
        if (
            $this->operator === '&&'
            && ($range % $this->termOne === 0
            && $range % $this->termTwo === 0)
        ) {
            $total += $range;
        }

        if ($this->operator === '||'
            && ($range % $this->termOne === 0
            || $range % $this->termTwo === 0)) {
            $total += $range;
        }
    }

    private function sumAllParameters(int &$total, int &$i): void
    {
        if (
            $this->operator === '&&'
            && ($i % $this->termOne === 0 && $i % $this->termTwo === 0)
            && ($i % $this->termThree === 0)
        ) {
            $total += $i;
        }

        if (
            $this->operator === '||'
            && ($i % $this->termOne === 0 || $i % $this->termTwo === 0)
            && ($i % $this->termThree === 0)
        ) {
            $total += $i;
        }
    }
}
