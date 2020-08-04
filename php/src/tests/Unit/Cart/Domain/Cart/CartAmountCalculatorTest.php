<?php

declare(strict_types = 1);

namespace App\Tests\Unit\Cart\Domain\Cart;

use App\Cart\Domain\Cart\Cart;
use App\Cart\Domain\Cart\CartAmountCalculator;
use App\Cart\Domain\Cart\Discount\DiscountAbstract;
use App\Cart\Domain\Cart\Money;
use App\Cart\Domain\Cart\ProductItem;
use App\Cart\Domain\Product\Product;
use App\Cart\Domain\Uuid;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;

class CartAmountCalculatorTest extends TestCase
{
    private const CURRENCY = 'EUR';

    private function randomUuid(): Uuid
    {
        return new Uuid(RamseyUuid::uuid4()->toString());
    }

    public function test_empty_calculator_works(): void
    {
        $price = 1000;
        $units = rand(2, 5);
        $cart = new Cart($this->randomUuid());
        $product = new Product('code', 'name', new Money($price, self::CURRENCY));
        $emptyCalculator = new CartAmountCalculator([]);

        $expectedAmount = new Money($price * $units, self::CURRENCY);

        for ($i = 0; $i < $units; $i++) {
            $cart->addProduct($product);
        }

        $totalAmount = ($emptyCalculator)($cart);

        $this->assertTrue($expectedAmount->isEquals($totalAmount));
    }

    public function test_discount_is_not_applied(): void
    {
        $priceAmount = 1000;
        $expectedAmount = new Money($priceAmount, self::CURRENCY);
        $code = 'code';
        $product = new Product($code, 'name', $expectedAmount);
        $productItem = ProductItem::create($product);
        $cart = new Cart($this->randomUuid());
        $cart->addProduct($product);

        $discount = $this->createMock(DiscountAbstract::class);
        $discount->expects($this->once())
            ->method('shouldApplyDiscount')
            ->with($productItem)
            ->willReturn(false);

        $discount->expects($this->never())
            ->method('apply');

        $calculator = new CartAmountCalculator([$discount]);

        $totalAmount = ($calculator)($cart);

        $this->assertTrue($expectedAmount->isEquals($totalAmount));
    }

    public function test_discount_is_applied(): void
    {
        $price = 1000;
        $expectedAmount = new Money($price * 2, self::CURRENCY);
        $code = 'code';
        $product = new Product($code, 'name', new Money($price, self::CURRENCY));
        $productItem = ProductItem::create($product);
        $cart = new Cart($this->randomUuid());
        $cart->addProduct($product);

        $discount = $this->createMock(DiscountAbstract::class);
        $discount->expects($this->once())
            ->method('shouldApplyDiscount')
            ->with($productItem)
            ->willReturn(true);

        $discount->expects($this->once())
            ->method('apply')
            ->with($productItem)
            ->willReturn($expectedAmount);

        $calculator = new CartAmountCalculator([$discount]);

        $totalAmount = ($calculator)($cart);

        $this->assertTrue($expectedAmount->isEquals($totalAmount));
    }
}
