<?php

declare(strict_types=1);

namespace App\ShippingCalculation\PostalService;

interface PostalService
{
    public function calculateShipping(string $zipCode): float;
}