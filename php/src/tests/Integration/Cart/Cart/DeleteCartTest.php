<?php

declare(strict_types = 1);

namespace App\Tests\Integration\Cart\Cart;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeleteCartTest extends WebTestCase
{
    private const URI = '/cart/%s';
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function test_when_cart_not_exists_it_responses_not_found_code()
    {
        $this->client->request('DELETE', sprintf(self::URI, RamseyUuid::uuid4()->toString()));
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function test_when_id_is_not_valid_uuid_it_responses_bad_request()
    {
        $this->client->request('DELETE', sprintf(self::URI, 'invalid_uuid'));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function test_when_cart_is_deleted_it_responses_no_content()
    {
        $cartId = Uuid::uuid4()->toString();

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
            'DELETE',
            sprintf(self::URI, $cartId)
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}
