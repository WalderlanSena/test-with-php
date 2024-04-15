<?php

declare(strict_types=1);

namespace Test\unit;

use App\ShippingCalculation\Domain\Product;
use App\ShippingCalculation\Domain\ShoppingCart;
use App\ShippingCalculation\Domain\User;
use App\ShippingCalculation\Exception\InvalidQuantity;
use App\ShippingCalculation\Infrastructure\Service\SedexService;
use App\ShippingCalculation\Infrastructure\Service\ShippingCalculationService;
use PHPUnit\Framework\TestCase;
use Random\Randomizer;

final class ShoppingCartTest extends TestCase
{
    public function testCanBeGetValueOfCart(): void
    {
        $user = $this->createMock(User::class);
        $shoppingCart = new ShoppingCart($user);

        $items = $shoppingCart->getItems();

        $this->assertEmpty($items);
    }

    public function testCanBeAddNewProducts(): void
    {
        $user = $this->createMock(User::class);
        $product = new Product(1, 'Clean Code Book', 100);

        $shoppingCart = new ShoppingCart($user);
        $shoppingCart->addItem($product, 1);
        $shoppingCartItems = $shoppingCart->getItems();

        $this->assertEquals($shoppingCartItems, [
            [
                'quantity' => 1,
                'product' => $product,
            ]
        ]);
    }

    public function testCanBeAddTwoProductInTheSameTime(): void
    {
        $user = $this->createMock(User::class);
        $product = new Product(1, 'Clean Code Book', 100);

        $shoppingCart = new ShoppingCart($user);

        $shoppingCart->addItem($product, 1);
        $shoppingCart->addItem($product, 1);

        $shoppingCartItems = $shoppingCart->getItems();

        $this->assertEquals($shoppingCartItems, [
            [
                'quantity' => 2,
                'product' => $product,
            ]
        ]);
    }

    public function testCanBeRemoveAProduct(): void
    {
        $user = $this->createMock(User::class);
        $product1 = new Product(1, 'Clean Code Book', 100);
        $product2 = new Product(2, 'Leaning Code Book', 30);

        $shoppingCart = new ShoppingCart($user);
        $shoppingCart->addItem($product1, 1);

        $shoppingCart->removeItem($product2);

        $this->assertCount(1, $shoppingCart->getItems());
    }

    public function testCanBeCleanTheShoppingCart(): void
    {
        $user = $this->createMock(User::class);
        $product1 = new Product(1, 'Clean Code Book', 100);
        $product2 = new Product(2, 'Leaning Code Book', 30);

        $shoppingCart = new ShoppingCart($user);
        $shoppingCart->addItem($product1, 1);
        $shoppingCart->addItem($product2, 2);

        $shoppingCart->clearItems();

        $this->assertCount(0, $shoppingCart->getItems());
    }

    public function testCanBeGetTotalPriceOfShoppingCart(): void
    {
        $user = $this->createMock(User::class);
        $product1 = new Product(1, 'Clean Code Book', 100);
        $product2 = new Product(2, 'Leaning Code Book', 30);

        $shoppingCart = new ShoppingCart($user);
        $shoppingCart->addItem($product1, 1);
        $shoppingCart->addItem($product2, 2);

        $total = $shoppingCart->getTotals();

        $this->assertEquals(160, $total);
    }

    public function testCheckIfCartTotalIsCorrectWhenValueIsLessThanOneHundred(): void
    {
        $user = $this->createMock(User::class);
        $shoppingCart = new ShoppingCart($user);
        $product1 = new Product(1, 'Clean Code Book', 34.96);
        $shoppingCart->addItem($product1, 1);

        $sedexService = new SedexService(new Randomizer());
        $shippingService = new ShippingCalculationService($sedexService);
        $total = $shoppingCart->getTotals() + $shippingService->calculateTotalValue($shoppingCart);

        $this->assertGreaterThan($shoppingCart->getTotals(), $total);
    }

    public function testCheckIfCartTotalIsCorrectWhenValueIsGreaterThanOneHundred(): void
    {
        $user = $this->createMock(User::class);
        $shoppingCart = new ShoppingCart($user);
        $product1 = new Product(1, 'Clean Code Book', 45.00);

        $shoppingCart->addItem($product1, 10);

        $sedexService = $this->createMock(SedexService::class);
        $shippingService = new ShippingCalculationService($sedexService);
        $total = $shoppingCart->getTotals() + $shippingService->calculateTotalValue($shoppingCart);

        $this->assertEquals($shoppingCart->getTotals(), $total);
    }

    public function testCheckIfMethodCalculateShippingExecutedOnce()
    {
        $sedexService = $this->createMock(SedexService::class);
        $sedexService->expects($spy = $this->any())->method('calculateShipping');
        $sedexService->calculateShipping('60740148');

        $this->assertEquals(1, $spy->numberOfInvocations());
    }

    public function testCheckIfMethodCalculateShippingExecutedTwoTimes()
    {
        $sedexService = $this->createMock(SedexService::class);
        $sedexService->expects($spy = $this->any())->method('calculateShipping');
        $sedexService->calculateShipping('60740148');
        $sedexService->calculateShipping('60740100');

        $this->assertEquals(2, $spy->numberOfInvocations());
    }

    public function testCheckIfMethodCalculateShippingResponseIsValid()
    {
        $sedexService = new SedexService(new Randomizer());
        $price = $sedexService->calculateShipping('60740148');

        $this->assertGreaterThan(0, $price);
    }

    public function testShouldNotAddProductsDuplicates()
    {
        $user = $this->createMock(User::class);
        $cart = new ShoppingCart($user);
        $productA = new Product(1, 'Clean Code Book', 54.67);

        $cart->addItem($productA, 1);
        $cart->addItem($productA, 3);

        $this->assertCount(1, $cart->getItems());
    }

    public function testCheckIfQuantityEqualsToZero()
    {
        $this->expectException(InvalidQuantity::class);

        $user = $this->createMock(User::class);
        $cart = new ShoppingCart($user);
        $productA = new Product(1, 'Clean Code Book', 45.13);

        $cart->addItem($productA, 0);
    }
}
