<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

class Street
{
    private int $number;

    private string $name;

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
