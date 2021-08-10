<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

class Location
{
    private Street $street;

    private string $city;

    private string $state;

    private string $country;

    private string $postcode;

    private Coordinates $coordinates;

    private Timezone $timezone;

    public function getStreet(): Street
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function getTimezone(): Timezone
    {
        return $this->timezone;
    }
}
