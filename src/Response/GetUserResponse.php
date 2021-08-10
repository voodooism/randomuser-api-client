<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\Response;

use JMS\Serializer\Annotation as Serializer;
use Voodooism\RandomUser\DTO\ResponseMetadata;
use Voodooism\RandomUser\DTO\User;

class GetUserResponse extends AbstractResponse
{
    /**
     * @Serializer\Type("array<Voodooism\RandomUser\DTO\User>")
     * @var User[]
     */
    private array $results;

    private ResponseMetadata $info;

    /**
     * @return User[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function getResponseMetadata(): ResponseMetadata
    {
        return $this->info;
    }
}
