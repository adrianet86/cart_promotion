<?php

declare(strict_types = 1);

namespace App\Cart\Application\Cart;

use App\Cart\Domain\Cart\Cart;
use App\Cart\Domain\Cart\CartRepository;
use App\Cart\Domain\Uuid;

class CartCreator
{
    private $repository;

    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CartCreatorRequest $request):void
    {
        $this->repository->save(
            new Cart(new Uuid($request->cartId()))
        );
    }

}
