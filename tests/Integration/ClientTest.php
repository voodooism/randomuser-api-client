<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\Test\Integration;

use GuzzleHttp\Client as HttpClient;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Voodooism\RandomUser\Client;
use Voodooism\RandomUser\ClientOptions;

class ClientTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $serializer = SerializerBuilder::create()->build();

        $options = new ClientOptions('https://randomuser.me');

        $this->client = new Client(
            $serializer,
            new HttpClient(),
            $options
        );
    }

    public function testGetRandomUser(): void
    {
        $user = $this->client->getRandomUser();

        $this->assertNotNull($user);
    }

    public function testGetRandomUsersFromUa(): void
    {
        $users = $this->client->getRandomUsers(10);

        $this->assertCount(10, $users);
    }
}