<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

readonly class LettersToNumbers
{
    public function __construct(
        private ?string $word,
    ){
        $this->validate($this->word);
    }

    private function validate(?string $word): void
    {
        if (is_null($word)) {
            throw new InvalidArgumentException('The word parameter cannot be null');
        }
    }

    public function run(): array
    {
        $value = $this->convertLettersToNumber($this->word);
        $happyNumber = new HappyNumbers($value);

        return [
            'primeNumber' => $this->isPrimeNumber($value),
            'happyNumber' => $happyNumber->run(),
            'multipleThreeOrFive' => $this->isMultipleThreeOrFive($value),
        ];
    }

    private function convertLettersToNumber(string $word): int
    {
        $letters = array_merge(range('a', 'z'), range('A', 'Z'));
        $letters = array_flip($letters);

        $total = 0;
        for ($i = 0; $i < strlen($word); $i++) {
            $letter = $word[$i];
            if (!isset($letters[$letter])) {
                continue;
            }

            $total += $letters[$letter] + 1;
        }

        return $total;
    }

    private function isMultipleThreeOrFive(int $number): bool
    {
        return ($number % 3 === 0) || ($number % 5 === 0);
    }

    private function isPrimeNumber(int $number): bool
    {
        if ($number <= 1) {
            return false;
        }

        for ($i = 2; $i <= $number / 2; $i++) {
            if ($number % $i === 0)
                return false;
        }

        return true;
    }
}
