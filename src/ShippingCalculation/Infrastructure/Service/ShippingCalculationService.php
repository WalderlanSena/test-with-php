<?php

declare(strict_types=1);

namespace App\ShippingCalculation\Infrastructure\Service;

use App\ShippingCalculation\Domain\ShoppingCart;

class ShippingCalculationService
{
    const int MIN_VALUE_TO_FREE_SHIPPING = 100;

    public function __construct(
        private SedexService $sedexService
    ){}

    public function calculateTotalValue(ShoppingCart $cart): float
    {
        $shippingValue = 0;
        if ($cart->getTotals() > self::MIN_VALUE_TO_FREE_SHIPPING) {
            return $shippingValue;
        }
        $user = $cart->getShoppingCarOwner();
        $zipCode = $user->getZipCode();
        $shoppingCost = $this->getShippingCost($zipCode);

        return $cart->getTotals() + $shoppingCost;
    }

    private function getShippingCost(string $zipCode): float
    {
        return $this->sedexService->calculateShipping($zipCode);
    }
}