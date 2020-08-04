<?php

declare(strict_types = 1);

namespace App\Cart\Application\Cart;

use App\Cart\Application\ArrayJsonResponse;
use App\Cart\Domain\Cart\CartAmountCalculator;
use App\Cart\Domain\Cart\CartRepository;
use App\Cart\Domain\Uuid;

class CartTotalAmountGetter
{
    private $repository;
    private $amountCalculator;

    public function __construct(CartRepository $repository, CartAmountCalculator $amountCalculator)
    {
        $this->repository = $repository;
        $this->amountCalculator = $amountCalculator;
    }

    public function __invoke(CartTotalAmountRequest $request): ArrayJsonResponse
    {
        $cart = $this->repository->find(new Uuid($request->cartId()));
        $amount = ($this->amountCalculator)($cart);

        return new CartTotalAmountResponseArray($cart->id()->toString(), $amount->toString());
    }
}
