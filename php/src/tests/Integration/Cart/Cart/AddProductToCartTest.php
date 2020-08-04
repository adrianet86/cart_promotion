<?php

declare(strict_types = 1);

namespace App\Tests\Integration\Cart\Cart;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AddProductToCartTest extends WebTestCase
{
    private const EXISTING_PRODUCT_CODE = 'PEN';

    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function test_when_id_is_not_valid_uuid_it_responses_bad_request()
    {
        $this->client->request(
            'POST',
            sprintf('/cart/invalid_uuid/product/code')
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function test_when_cart_not_exists_it_responses_not_found()
    {
        $this->client->request(
            'POST',
            sprintf('/cart/%s/product/code', RamseyUuid::uuid4()->toString())
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function test_when_product_is_added_to_existing_cart_it_responses_created_code()
    {
        $cartId = RamseyUuid::uuid4()->toString();
        $this->client->request(
            'POST',
            'cart',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'id' => $cartId
            ])
        );

        $this->client->request(
            'POST',
            sprintf('/cart/%s/product/%s', $cartId, self::EXISTING_PRODUCT_CODE)
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    public function test_when_product_not_exists_it_responses_not_found_code()
    {
        $cartId = RamseyUuid::uuid4()->toString();
        $this->client->request(
            'POST',
            'cart',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'id' => $cartId
            ])
        );

        $this->client->request(
            'POST',
            sprintf('/cart/%s/product/%s', $cartId, 'non_existing')
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
