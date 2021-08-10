<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

class ResponseMetadata
{
    private string $seed;

    private int $results;

    private int $page;

    private string $version;

    public function getSeed(): string
    {
        return $this->seed;
    }

    public function getResults(): int
    {
        return $this->results;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getVersion(): string
    {
        return $this->version;
    }
}
