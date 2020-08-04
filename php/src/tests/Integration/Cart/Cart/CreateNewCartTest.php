<?php

declare(strict_types = 1);

namespace App\Tests\Integration\Cart\Cart;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateNewCartTest extends WebTestCase
{
    private const URI = 'cart';
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function test_when_id_is_not_valid_uuid_it_responses_bad_request()
    {
        $this->client->request(
            'POST',
            self::URI,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'id' => 'invalid_uuid'
            ])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function test_when_new_cart_is_created_it_responses_created_code()
    {
        $this->client->request(
            'POST',
            self::URI,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'id' => RamseyUuid::uuid4()->toString()
            ])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }
}
