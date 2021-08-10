<?php
declare(strict_types=1);

namespace Voodooism\RandomUser;

use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\UriInterface;
use Voodooism\RandomUser\Enum\ApiVersionEnum;

/**
 * @psalm-immutable
 */
class ClientOptions
{
    private const DEFAULT_TIMEOUT_SEC = 30;

    private UriInterface $uri;

    private string $version;

    private int $connectionTimeout;

    private int $requestTimeout;

    public function __construct(
        string $uri,
        string $version = ApiVersionEnum::V_1_3,
        int $connectionTimeout = self::DEFAULT_TIMEOUT_SEC,
        int $requestTimeout = self::DEFAULT_TIMEOUT_SEC
    ) {
        $this->uri = Utils::uriFor($uri);
        $this->version = $version;
        $this->connectionTimeout = $connectionTimeout;
        $this->requestTimeout = $requestTimeout;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getConnectionTimeout(): int
    {
        return $this->connectionTimeout;
    }

    public function getRequestTimeout(): int
    {
        return $this->requestTimeout;
    }
}
