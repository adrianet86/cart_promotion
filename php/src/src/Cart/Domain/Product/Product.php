<?php

declare(strict_types = 1);

namespace App\Cart\Domain\Product;

use App\Cart\Domain\Cart\Money;

class Product
{
    private $code;
    private $name;
    private $price;

    public function __construct(string $code, string $name, Money $price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function code(): string
    {
        return $this->code;
    }

}