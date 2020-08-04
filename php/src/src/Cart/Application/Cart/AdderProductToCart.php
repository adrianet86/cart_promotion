<?php

declare(strict_types = 1);

namespace App\Cart\Application\Cart;

use App\Cart\Domain\Cart\CartRepository;
use App\Cart\Domain\Product\ProductRepository;
use App\Cart\Domain\Uuid;

class AdderProductToCart
{
    private $cartRepository;
    private $productRepository;

    public function __construct(CartRepository $cartRepository, ProductRepository $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function __invoke(AdderProductToCartRequest $request): void
    {
        $cart = $this->cartRepository->find(new Uuid($request->cartId()));
        $product = $this->productRepository->findByCode($request->productCode());

        $cart->addProduct($product);

        $this->cartRepository->save($cart);
    }
}
