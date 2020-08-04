<?php

declare(strict_types = 1);

namespace App\Cart\Domain\Cart;

use App\Cart\Domain\Product\Product;
use App\Cart\Domain\Product\ProductItem;
use App\Cart\Domain\Uuid;

class Cart
{
    private $id;
    private $items;

    public function __construct(Uuid $id)
    {
        $this->id = $id;
        $this->items = [];
    }

    private function codeToKey(string $code): string
    {
        return md5($code);
    }

    public function addProduct(Product $product): void
    {
        $code = $product->code();

        if (!$this->existsProduct($code)) {
            $this->items[$this->codeToKey($code)] = ProductItem::create($product);
        } else {
            $this->getProductByCode($code)->addUnits(1);
        }
    }

    private function existsProduct(string $code): bool
    {
        return array_key_exists($this->codeToKey($code), $this->items);
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function items(): array
    {
        return $this->items;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function totalProducts(): int
    {
        return count($this->items);
    }

    public function getProductByCode(string $code): ?ProductItem
    {
        if ($this->existsProduct($code)) {
            return $this->items[$this->codeToKey($code)];
        }

        return null;
    }
}
