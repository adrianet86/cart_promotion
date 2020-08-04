<?php

declare(strict_types = 1);

namespace App\Cart\Infrastructure\Persistence\Memory\Product;

use App\Cart\Domain\Cart\Money;
use App\Cart\Domain\Product\Product;
use App\Cart\Domain\Product\ProductNotFoundException;
use App\Cart\Domain\Product\ProductRepository;

class MemoryProductRepository implements ProductRepository
{
    private const CURRENCY_EUR = 'EUR';

    private $products = [
        'PEN' => [
            'name' => 'Lana Pen',
            'amount' => 500,
            'currency' => self::CURRENCY_EUR
        ],
        'TSHIRT' => [
            'name' => 'Lana T-Shirt',
            'amount' => 2000,
            'currency' => self::CURRENCY_EUR
        ],
        'MUG' => [
            'name' => 'Lana Coffee Mug',
            'amount' => 750,
            'currency' => self::CURRENCY_EUR
        ]
    ];

    public function findByCode(string $code): Product
    {
        if (!isset($this->products[$code])) {
            throw new ProductNotFoundException();
        }

        return new Product(
            $code,
            $this->products[$code]['name'],
            new Money($this->products[$code]['amount'], $this->products[$code]['currency'])
        );
    }
}
