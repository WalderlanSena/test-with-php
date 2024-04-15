<?php

declare(strict_types=1);

namespace App\ShippingCalculation\Domain;

use App\ShippingCalculation\Exception\InvalidQuantity;

class ShoppingCart
{
    private array $items;

    public function __construct(
        private readonly User $user,
    ){
        $this->items = [];
    }

    public function addItem(Product $product, int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidQuantity('The quantity must be more than 0');
        }

        $items = $this->getItems();

        foreach ($items as $key => $item) {
            $productItem = $item['product'];
            if ($productItem->getId() === $product->getId()) {
                $this->items[$key]['quantity'] += $quantity;
                return;
            }
        }

        $this->items[] = [
            'quantity' => $quantity,
            'product' => $product,
        ];
    }

    public function removeItem(Product $product, ?int $quantity = null): void
    {
        $items = $this->getItems();
        foreach ($items as $key => $item) {
            $productItem = $item['product'];
            $quantityItem = $item['quantity'];

            if ($product->getId() != $productItem->getId()) {
                continue;
            }

            if (is_null($quantity) || $quantity >= $quantityItem) {
                unset($this->items[$key]);
                break;
            }

            $newItem = [
                'product' => $product,
                'quantity' => $item['qty'] - $quantity,
            ];

            $this->items[$key] = $newItem;
        }
    }

    public function clearItems(): void
    {
        $this->items = [];
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotals(): float
    {
        $total = 0;
        $items = $this->getItems();
        foreach ($items as $item) {
            $product = $item['product'];
            $total += ($product->getPrice() * $item['quantity']);
        }

        return $total;
    }

    public function getShoppingCarOwner(): User
    {
        return $this->user;
    }
}
