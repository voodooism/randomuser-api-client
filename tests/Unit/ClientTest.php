<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\Test\Unit;

use DateTimeImmutable;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Voodooism\RandomUser\Client;
use Voodooism\RandomUser\ClientOptions;

class ClientTest extends TestCase
{
    public function testWithOptionsImmutable(): void
    {
        $client = $this->createClient();

        $options = new ClientOptions(
            'http://test.uri'
        );

        $clientWithNewOptions = $client->withOptions($options);

        $this->assertNotSame($client, $clientWithNewOptions);
    }

    public function testRequestWithoutClientOptionsIsInitialized(): void
    {
        $client = $this->createClient();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('You must specify client options!');

        $client->getRandomUser();
    }

    public function testGetRandomUserSuccessfully(): void
    {
        $responseArray = [
            'results' => [
                [
                    'gender' => $gender = 'male',
                    'name' => [
                        'title' => $nameTitle = "Mr",
                        'first' => $nameFirst = "Melvin",
                        'last' =>  $nameLast = "Simpson"
                    ],
                    'location' => [
                        'street' => [
                            'number' =>  $streetNumber = 2971,
                            'name' => $streetName = 'Killarney Road'
                        ],
                        'city' => $city = "Ripon",
                        'state' => $state = "Somerset",
                        'country' => $country = "United Kingdom",
                        'postcode' => $postcode = "W3 6RF",
                        'coordinates' => [
                            'latitude' => $latitude = '19.6342',
                            'longitude' => $longitude = '-84.5838'
                        ],
                        'timezone' => [
                            'offset' => $timezoneOffset = '0:00',
                            'description' => $timezoneDescription = 'Western Europe Time, London, Lisbon, Casablanca'
                        ]
                    ],
                    'email' => $email = 'melvin.simpson@example.com',
                    'login' => [
                        'uuid'  => $uuid = "ada1fbca-043b-4887-bac7-6e36fe250bf2",
                        'username'  => $username = "silverladybug487",
                        'password'  => $password =  "nnnnnnnn",
                        'salt'  => $salt = "bpoTGFDn",
                        'md5'  => $md5 = "30ae84d2ebd68bf79d857d554ac6b3e8",
                        'sha1'  => $sha1 = "d20c1e1f91733da4877f55d2c273cf21f2d0ec42",
                        'sha256'  => $sha256 = "75344daa8f430a4299ea21f371d9dccd1f8e11f937fd11870f08b419c8a5df6c"
                    ],
                    'dob' => [
                        'date' => $dobDate = "1993-09-24T21:24:20.575Z",
                        'age' => $dobAge = 28
                    ],
                    'registered' => [
                        'date' => $registeredDate = "2006-06-21T15:41:37.647Z",
                        'age' => $registeredAge = 15
                    ],
                    'phone' => $phone = "0161 642 8016",
                    'cell' => $cell = "0719-718-617",
                    'id' => [
                        'name' =>  $idName = "NINO",
                        'value' => $idValue = "AR 93 89 21 U"
                    ],
                    'picture' => [
                        'large' => $pictureLarge = "https://randomuser.me/api/portraits/men/41.jpg",
                        'medium' => $pictureMedium = "https://randomuser.me/api/portraits/med/men/41.jpg",
                        'thumbnail' => $pictureThumbnail = "https://randomuser.me/api/portraits/thumb/men/41.jpg"
                    ],
                    'nat' => $nat = 'IE',
                ]
            ]
        ];

        $expectedResponse = new Response(
            200,
            [],
            json_encode($responseArray)
        );

        $client = $this->createClient($expectedResponse)->withOptions(new ClientOptions('https://test.uri'));

        $user = $client->getRandomUser();

        $this->assertEquals($gender, $user->getGender());

        $this->assertNotNull($name = $user->getName());
        $this->assertEquals($nameTitle, $name->getTitle());
        $this->assertEquals($nameFirst, $name->getFirst());
        $this->assertEquals($nameLast, $name->getLast());

        $this->assertNotNull($location = $user->getLocation());

        $this->assertNotNull($street = $location->getStreet());
        $this->assertEquals($streetName, $street->getName());
        $this->assertEquals($streetNumber, $street->getNumber());

        $this->assertEquals($city, $location->getCity());
        $this->assertEquals($state, $location->getState());
        $this->assertEquals($country, $location->getCountry());
        $this->assertEquals($postcode, $location->getPostcode());

        $this->assertNotNull($coordinates = $location->getCoordinates());
        $this->assertEquals($latitude, $coordinates->getLatitude());
        $this->assertEquals($longitude, $coordinates->getLongitude());

        $this->assertNotNull($timezone = $location->getTimezone());
        $this->assertEquals($timezoneOffset, $timezone->getOffset());
        $this->assertEquals($timezoneDescription, $timezone->getDescription());

        $this->assertEquals($email, $user->getEmail());

        $this->assertNotNull($login = $user->getLogin());
        $this->assertEquals($uuid, $login->getUuid());
        $this->assertEquals($username, $login->getUsername());
        $this->assertEquals($password, $login->getPassword());
        $this->assertEquals($salt, $login->getSalt());
        $this->assertEquals($md5, $login->getMd5());
        $this->assertEquals($sha1, $login->getSha1());
        $this->assertEquals($sha256, $login->getSha256());

        $this->assertNotNull($dob = $user->getDob());
        $this->assertEquals($dobAge, $dob->getAge());
        $this->assertEquals(new DateTimeImmutable($dobDate), $dob->getDate());

        $this->assertNotNull($registrationDate = $user->getRegistered());
        $this->assertEquals($registeredAge, $registrationDate->getAge());
        $this->assertEquals(new DateTimeImmutable($registeredDate), $registrationDate->getDate());

        $this->assertEquals($phone, $user->getPhone());
        $this->assertEquals($cell, $user->getCell());

        $this->assertNotNull($id = $user->getId());
        $this->assertEquals($idValue, $id->getValue());
        $this->assertEquals($idName, $id->getName());

        $this->assertNotNull($picture = $user->getPicture());
        $this->assertNotNull($pictureLarge, $picture->getLarge());
        $this->assertNotNull($pictureMedium, $picture->getMedium());
        $this->assertNotNull($pictureThumbnail, $picture->getThumbnail());

        $this->assertEquals($nat, $user->getNat());
    }


    public function testGetRandomUserReturnsMoreThanOne(): void
    {
        $responseArray = [
            'results' => [
                [],
                []
            ]
        ];

        $expectedResponse = new Response(
            200,
            [],
            json_encode($responseArray)
        );

        $client = $this->createClient($expectedResponse)->withOptions(new ClientOptions('https://test.uri'));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Wrong amount of users returned. `2` returned while exactly one expected');
        $client->getRandomUser();
    }

    public function testGetRandomUsersLessThanTwo(): void
    {
        $client = $this->createClient()->withOptions(new ClientOptions('https://test.uri'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The first argument should be positive value.');
        $client->getRandomUsers(-1);
    }

    public function testGetRandomUsersReturnsWrongCount(): void
    {
        $responseArray = [
            'results' => [
                [],
                [],
                [],
            ]
        ];

        $expectedResponse = new Response(
            200,
            [],
            json_encode($responseArray)
        );

        $client = $this->createClient($expectedResponse)->withOptions(new ClientOptions('https://test.uri'));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Wrong amount of users returned. `3` returned while `2` expected');
        $client->getRandomUsers(2);
    }
    private function createClient(Response $response = null): Client
    {
        if ($response !== null) {
            $mock = new MockHandler([$response]);

            $handlerStack = HandlerStack::create($mock);
            $httpClient = new HttpClient(['handler' => $handlerStack]);
        }

        $httpClient = $httpClient ?? $this->createMock(HttpClient::class);

        return new Client(
            SerializerBuilder::create()->build(),
            $httpClient
        );
    }
}