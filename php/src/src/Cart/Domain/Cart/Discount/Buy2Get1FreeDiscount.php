<?php

declare(strict_types = 1);

namespace App\Cart\Domain\Cart\Discount;

use App\Cart\Domain\Cart\Money;
use App\Cart\Domain\Cart\ProductItem;

class Buy2Get1FreeDiscount extends DiscountAbstract implements Discount
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

        $unitsToDiscount = (int)floor($item->units() / 2);
        if ($unitsToDiscount <= 0) {
            return $totalAmount;
        }

        $priceToDiscount = $item->product()->price()->amount() * $unitsToDiscount;

        return $totalAmount->subtract(
            new Money(
                $priceToDiscount,
                $totalAmount->currency()
            )
        );
    }
}