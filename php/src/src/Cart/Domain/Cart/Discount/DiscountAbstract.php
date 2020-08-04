<?php

declare(strict_types = 1);

namespace App\Cart\Domain\Cart\Discount;

use App\Cart\Domain\Cart\Money;
use App\Cart\Domain\Product\ProductItem;

abstract class DiscountAbstract implements Discount
{
    protected $productCode;

    public function shouldApplyDiscount(ProductItem $product): bool
    {
        return $product->product()->code() === $this->productCode;
    }

    abstract public function apply(ProductItem $item): Money;
}
