<?php

declare(strict_types = 1);

namespace App\Tests\Integration\Cart\Cart;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetCartAmountTest extends WebTestCase
{
    private const URI = '/cart/%s/amount';
    private const EXISTING_PRODUCT_CODE = 'PEN';

    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function test_when_id_is_not_valid_uuid_it_responses_bad_request()
    {
        $this->client->request('GET', sprintf(self::URI, 'invalid_uuid'));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function test_when_cart_not_exist_it_responses_not_found()
    {
        $this->client->request('GET', sprintf(self::URI, RamseyUuid::uuid4()->toString()));
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function test_when_response_is_ok_it_has_expected_json_structure()
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
        $this->client->request('GET', sprintf(self::URI, $cartId));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('total_amount', $response);
    }
}
