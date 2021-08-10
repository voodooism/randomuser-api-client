<?php
declare(strict_types=1);

namespace Voodooism\RandomUser;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use InvalidArgumentException;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\UriInterface;
use RuntimeException;
use Voodooism\RandomUser\DTO\User;
use Voodooism\RandomUser\Enum\HttpVerbEnum;
use Voodooism\RandomUser\Request\RequestOptions;
use Voodooism\RandomUser\Response\AbstractResponse;
use Voodooism\RandomUser\Response\GetUserResponse;

class Client
{
    private const SERIALIZATION_FORMAT = 'json';

    private SerializerInterface $serializer;

    private HttpClient $httpClient;

    private ?ClientOptions $options = null;

    public function __construct(
        SerializerInterface $serializer,
        HttpClient $httpClient,
        ?ClientOptions $options = null
    ) {
        $this->serializer = $serializer;
        $this->httpClient = $httpClient;

        if ($options !== null) {
            $this->setOptions($options);
        }
    }

    public function withOptions(ClientOptions $options): self
    {
        $clone = clone $this;

        $clone->setOptions($options);

        return $clone;
    }

    public function getRandomUser(RequestOptions $requestOptions = null): User
    {
        $clientOptions = $this->getOptions();

        $path = sprintf('/api/%s', $clientOptions->getVersion());

        $uri = $clientOptions
            ->getUri()
            ->withPath($path);

        if ($requestOptions !== null) {
            $queryString = $requestOptions->buildQueryString();
            $uri = $uri->withQuery($queryString);
        }

        $response = $this->request($uri, HttpVerbEnum::GET, GetUserResponse::class);

        $users  = $response->getResults();

        if (count($users) !== 1) {
            throw new RuntimeException(
                sprintf(
                    'Wrong amount of users returned. `%d` returned while exactly one expected',
                    count($users)
                )
            );
        }

        return $users[0];
    }

    /**
     * @return User[]
     */
    public function getRandomUsers(int $count, RequestOptions $requestOptions = null): array
    {
        if ($count < 1) {
            throw new InvalidArgumentException('The first argument should be positive value.');
        }

        $clientOptions = $this->getOptions();

        $path = sprintf('/api/%s', $clientOptions->getVersion());

        $uri = $clientOptions
            ->getUri()
            ->withPath($path);

        $queryString = sprintf('results=%d', $count);

        if ($requestOptions) {
            $queryString = sprintf('%s&%s', $queryString, $requestOptions->buildQueryString());
        }

        $uri = $uri->withQuery($queryString);

        $response = $this->request($uri, HttpVerbEnum::GET, GetUserResponse::class);

        $users  = $response->getResults();

        if (count($users) !== $count) {
            throw new RuntimeException(
                sprintf(
                    'Wrong amount of users returned. `%d` returned while `%s` expected',
                    count($users),
                    $count
                )
            );
        }

        return $users;
    }

    private function getOptions(): ClientOptions
    {
        if ($this->options === null) {
            throw new RuntimeException('You must specify client options!');
        }

        return $this->options;
    }

    private function setOptions(ClientOptions $options): void
    {
        $this->options = $options;
    }

    /**
     * @template T of AbstractResponse
     * @psalm-param T::class $expectedResponseClass
     * @return T
     *
     * @throws GuzzleException
     */
    private function request(
        UriInterface $uri,
        string $httpMethod,
        string $expectedResponseClass
    ): AbstractResponse {
        $httpRequest = new Request($httpMethod, $uri);

        $clientOptions = $this->getOptions();

        $httpResponse = $this->httpClient->send(
            $httpRequest,
            [
                GuzzleRequestOptions::CONNECT_TIMEOUT => $clientOptions->getConnectionTimeout(),
                GuzzleRequestOptions::TIMEOUT         => $clientOptions->getRequestTimeout(),
            ]
        );

        $httpResponseBody = (string)$httpResponse->getBody();

        $responseEntity = $this->serializer
            ->deserialize(
                $httpResponseBody,
                $expectedResponseClass,
                self::SERIALIZATION_FORMAT
            );

        return $responseEntity;
    }
}
