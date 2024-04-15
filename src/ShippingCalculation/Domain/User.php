<?php

declare(strict_types=1);

namespace App\ShippingCalculation\Domain;

class User
{
    public function __construct(
        private readonly string $name,
        private readonly string $zipCode,
    ){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }
}
