<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

class UserId
{
    private string $name;

    private ?string $value = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
