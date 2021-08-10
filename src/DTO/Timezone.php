<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

class Timezone
{
    private string $offset;

    private string $description;

    public function getOffset(): string
    {
        return $this->offset;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
