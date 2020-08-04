<?php

declare(strict_types = 1);

namespace App\Cart\Domain\Cart\Discount;

use App\Cart\Domain\Cart\Money;
use App\Cart\Domain\Product\ProductItem;

class Buy3Get25PerCentDiscount extends DiscountAbstract implements Discount
{
    public function __construct(string $productCode)
    {
        $this->productCode = $productCode;
    }

    public function apply(ProductItem $item): Money
    {
        $totalAmount = $item->totalAmount();
        if (!$this->shouldApplyDiscount($item)) {
            return $totalAmount;
        }

        if ($item->units() < 3) {
            return $totalAmount;
        }

        $price = (int) round($totalAmount->amount() * 0.75, 0);

        return new Money(
            $price,
            $totalAmount->currency()
        );
    }
}
