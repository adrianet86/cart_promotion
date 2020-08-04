<?php

declare(strict_types = 1);

namespace App\Cart\Application\Cart;

class AdderProductToCartRequest
{
    private $cartId;
    private $productCode;

    public function __construct(string $cartId, string $productCode)
    {
        $this->cartId = $cartId;
        $this->productCode = $productCode;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }

    public function productCode(): string
    {
        return $this->productCode;
    }
}
