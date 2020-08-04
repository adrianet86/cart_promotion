<?php

declare(strict_types = 1);

namespace App\Tests\Unit\Cart\Domain\Cart;

use App\Cart\Domain\Cart\Discount\Buy2Get1FreeDiscount;
use App\Cart\Domain\Cart\Money;
use App\Cart\Domain\Cart\ProductItem;
use App\Cart\Domain\Product\Product;
use PHPUnit\Framework\TestCase;

class Buy2Get1FreeDiscountTest extends TestCase
{
    public function test_buy_two_get_one_free(): void
    {
        $code = 'code';
        $price = new Money(1000, 'EUR');
        $items = 2;
        $product = new Product($code, 'name', $price);
        $discount = new Buy2Get1FreeDiscount($code);

        $totalAmount = $discount->apply(ProductItem::createWithUnits($product, $items));

        $this->assertTrue($totalAmount->isEquals($price));
    }

    public function test_buy_three_get_one_free(): void
    {
        $code = 'code';
        $priceAmount = 1000;
        $price = new Money($priceAmount, 'EUR');
        $expectedPrice = new Money($priceAmount * 2, 'EUR');
        $units = 3;
        $product = new Product($code, 'name', $price);
        $productItem = ProductItem::createWithUnits($product, $units);
        $discount = new Buy2Get1FreeDiscount($code);

        $totalAmount = $discount->apply($productItem);

        $this->assertTrue($totalAmount->isEquals($expectedPrice));
    }

    public function test_buy_four_get_two_free(): void
    {
        $code = 'code';
        $priceAmount = 1000;
        $items = 4;
        $price = new Money($priceAmount, 'EUR');
        $expectedAmount = new Money($priceAmount * 2, 'EUR');
        $product = new Product($code, 'name', $price);
        $discount = new Buy2Get1FreeDiscount($code);

        $totalAmount = $discount->apply(ProductItem::createWithUnits($product, $items));

        $this->assertTrue($totalAmount->isEquals($expectedAmount));
    }
}
