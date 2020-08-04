<?php

declare(strict_types = 1);

namespace App\Cart\Infrastructure\Api\Cart;

use App\Cart\Application\Cart\AdderProductToCart;
use App\Cart\Application\Cart\AdderProductToCartRequest;
use App\Cart\Domain\Cart\CartNotFoundException;
use App\Cart\Domain\InvalidUuidException;
use App\Cart\Domain\Product\ProductNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostProductToCartController extends AbstractController
{
    private $adderProductToCart;

    public function __construct(AdderProductToCart $adderProductToCart)
    {
        $this->adderProductToCart = $adderProductToCart;
    }

    public function __invoke(string $id, string $code): JsonResponse
    {
        try {
            ($this->adderProductToCart)(new AdderProductToCartRequest($id, $code));
            $response = null;
            $httpCode = Response::HTTP_CREATED;
        } catch (InvalidUuidException $exception) {
            $response = $exception->getMessage();
            $httpCode = Response::HTTP_BAD_REQUEST;
        } catch (ProductNotFoundException $exception) {
            $response = $exception->getMessage();
            $httpCode = Response::HTTP_NOT_FOUND;
        } catch (CartNotFoundException $exception) {
            $response = $exception->getMessage();
            $httpCode = Response::HTTP_NOT_FOUND;
        } catch (\Exception $exception) {
            $response = $exception->getMessage();
            $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new JsonResponse($response, $httpCode);
    }
}
