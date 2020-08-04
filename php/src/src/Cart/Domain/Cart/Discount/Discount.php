<?php

declare(strict_types = 1);

namespace App\Cart\Domain\Cart\Discount;

use App\Cart\Domain\Cart\Money;
use App\Cart\Domain\Product\ProductItem;

interface Discount
{
    public function shouldApplyDiscount(ProductItem $item): bool;

    public function apply(ProductItem $item): Money;
}
