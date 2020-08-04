<?php

declare(strict_types = 1);

namespace App\Cart\Domain\Product;

use App\Cart\Domain\Uuid;

interface ProductRepository
{
    public function findByCode(string $code): Product;
}
