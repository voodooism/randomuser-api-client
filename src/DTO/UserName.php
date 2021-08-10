<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

class UserName
{
    private string $title;

    private string $first;

    private string $last;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getFirst(): string
    {
        return $this->first;
    }

    public function getLast(): string
    {
        return $this->last;
    }
}
