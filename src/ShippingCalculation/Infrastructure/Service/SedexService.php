<?php

declare(strict_types=1);

namespace App\ShippingCalculation\Infrastructure\Service;

use App\ShippingCalculation\PostalService\CorreioService;
use Random\Randomizer;

class SedexService implements CorreioService
{
    public function __construct(
        private readonly Randomizer $randomizer,
    ){}

    public function calculateShipping(string $zipCode): float
    {
        return $this->randomizer->getFloat(5, 10);
    }
}
