<?php

declare(strict_types = 1);

namespace App\Cart\Infrastructure\Api\Cart;

use App\Cart\Application\Cart\AdderProductToCart;
use App\Cart\Application\Cart\AdderProductToCartRequest;
use App\Cart\Application\Cart\CartCreator;
use App\Cart\Application\Cart\CartCreatorRequest;
use App\Cart\Domain\InvalidUuidException;
use App\Cart\Domain\Product\ProductSellerNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostCartController extends AbstractController
{
    private $creator;

    public function __construct(CartCreator $adderProductToCart)
    {
        $this->creator = $adderProductToCart;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $cartId = isset($data['id']) ? $data['id'] : '';
            ($this->creator)(new CartCreatorRequest($cartId));
            $response = null;
            $httpCode = Response::HTTP_CREATED;
        } catch (InvalidUuidException $exception) {
            $response = $exception->getMessage();
            $httpCode = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            $response = $exception->getMessage();
            $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new JsonResponse($response, $httpCode);
    }
}
