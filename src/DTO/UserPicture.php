<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

class UserPicture
{
    private string $large;

    private string $medium;

    private string $thumbnail;

    public function getLarge(): string
    {
        return $this->large;
    }

    public function getMedium(): string
    {
        return $this->medium;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }
}
