<?php

declare(strict_types = 1);

namespace App\Cart\Domain\Product;

use App\Cart\Domain\Cart\InvalidUnitsException;
use App\Cart\Domain\Cart\Money;

class ProductItem
{
    private const ONE_UNIT = 1;

    private $product;
    private $units;

    private function __construct(Product $product, int $units)
    {
        if ($units <= 0) {
            throw new InvalidUnitsException(sprintf('Units must be bigger than 0'));
        }
        $this->product = $product;
        $this->units = $units;
    }

    public static function create(Product $product): self
    {
        return new self($product, self::ONE_UNIT);
    }

    public static function createWithUnits(Product $product, int $units): self
    {
        return new self($product, $units);
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function units(): int
    {
        return $this->units;
    }

    public function addUnits(int $units): void
    {
        $this->units += $units;
    }

    public function totalAmount(): Money
    {
        return new Money($this->units() * $this->product()->price()->amount(), $this->product()->price()->currency());
    }
}