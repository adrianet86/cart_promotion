<?php

declare(strict_types = 1);

namespace App\Cart\Domain\Cart;

use App\Cart\Domain\Product\ProductItem;

class CartAmountCalculator
{
    private const DEFAULT_CURRENCY = 'EUR';

    private $discounts;

    public function __construct(array $discounts = [])
    {
        $this->discounts = $discounts;
    }

    public function __invoke(Cart $cart, string $currency = self::DEFAULT_CURRENCY): Money
    {
        $totalAmount = new Money(0, $currency);
        if ($cart->isEmpty()) {
            return $totalAmount;
        }

        foreach ($cart->items() as $item) {
            $amountToAdd = $this->getTotalAmountWithDiscount($item);
            $totalAmount = $totalAmount->add($amountToAdd);
        }

        return $totalAmount;
    }

    private function getTotalAmountWithDiscount(ProductItem $item): Money
    {
        if (!empty($this->discounts)) {
            foreach ($this->discounts as $discount) {
                if ($discount->shouldApplyDiscount($item)) {
                    return $discount->apply($item);
                }
            }
        }

        return $item->totalAmount();
    }
}
