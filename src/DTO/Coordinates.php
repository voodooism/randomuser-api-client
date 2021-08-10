<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

class Coordinates
{
    private string $latitude;

    private string $longitude;

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }
}
