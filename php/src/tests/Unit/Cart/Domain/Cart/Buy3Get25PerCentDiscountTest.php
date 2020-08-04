<?php

declare(strict_types = 1);

namespace App\Tests\Unit\Cart\Domain\Cart;

use App\Cart\Domain\Cart\Discount\Buy3Get25PerCentDiscount;
use App\Cart\Domain\Cart\Money;
use App\Cart\Domain\Product\ProductItem;
use App\Cart\Domain\Product\Product;
use PHPUnit\Framework\TestCase;

class Buy3Get25PerCentDiscountTest extends TestCase
{
    public function test_buy_two_get_no_discount_free(): void
    {
        $code = 'code';
        $price = new Money(1000, 'EUR');
        $units = 2;
        $expectedAmount = new Money(1000 * $units, 'EUR');
        $product = new Product($code, 'name', $price);
        $discount = new Buy3Get25PerCentDiscount($code);

        $totalAmount = $discount->apply(ProductItem::createWithUnits($product, $units));

        $this->assertTrue($totalAmount->isEquals($expectedAmount));
    }

    public function test_buy_three_get_discount(): void
    {
        $code = 'code';
        $priceAmount = 1000;
        $price = new Money($priceAmount, 'EUR');
        $units = 3;
        $expectedAmount = intval(($priceAmount * $units) * 0.75);
        $expectedPrice = new Money($expectedAmount, 'EUR');
        $product = new Product($code, 'name', $price);
        $productItem = ProductItem::createWithUnits($product, $units);
        $discount = new Buy3Get25PerCentDiscount($code);

        $totalAmount = $discount->apply($productItem);

        $this->assertTrue($totalAmount->isEquals($expectedPrice));
    }

}
