<?php

declare(strict_types = 1);

namespace App\Tests\Unit\Cart\Domain\Cart;

use App\Cart\Domain\Cart\Cart;
use App\Cart\Domain\Cart\Money;
use App\Cart\Domain\Product\Product;
use App\Cart\Domain\Uuid;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;

class CartTest extends TestCase
{
    const CURRENCY = 'EUR';

    public function test_add_one_product_works()
    {
        $product = $this->createMock(Product::class);
        $cart = new Cart(new Uuid(RamseyUuid::uuid4()->toString()));

        $cart->addProduct($product);

        $this->assertEquals(1, $cart->totalProducts());
    }

    public function test_add_same_product_increases_units()
    {
        $product = new Product('code', 'name', new Money(1000, self::CURRENCY));

        $cart = new Cart(new Uuid(RamseyUuid::uuid4()->toString()));
        $totalUnits = rand(3, 10);

        for ($i = 1; $i <= $totalUnits; $i++) {
            $cart->addProduct($product);
        }
        $productItem = $cart->getProductByCode($product->code());

        $this->assertEquals(1, $cart->totalProducts());
        $this->assertEquals($totalUnits, $productItem->units());
    }

    public function test_add_many_different_products_works()
    {
        $cart = new Cart(new Uuid(RamseyUuid::uuid4()->toString()));
        $cart->addProduct($product = new Product('code', 'name', new Money(1000, self::CURRENCY)));
        $cart->addProduct($product = new Product('code2', 'name', new Money(1000, self::CURRENCY)));

        $this->assertEquals(2, $cart->totalProducts());
    }

}
