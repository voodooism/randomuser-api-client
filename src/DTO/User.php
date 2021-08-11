<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

class User
{
    private string $gender;

    private UserName $name;

    private Location $location;

    private string $email;

    private Login $login;

    private DateOfBirth $dob;

    private UserRegisteredDate $registered;

    private string $phone;

    private string $cell;

    private UserId $id;

    private UserPicture $picture;

    private string $nat;

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getName(): UserName
    {
        return $this->name;
    }

    public function getFirstName(): string
    {
        return $this->name->getFirst();
    }

    public function getLastName(): string
    {
        return $this->name->getLast();
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getCountry(): string
    {
        return $this->location->getCountry();
    }

    public function getCity(): string
    {
        return $this->location->getCity();
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getLogin(): Login
    {
        return $this->login;
    }

    public function getUserName(): string
    {
        return $this->login->getUsername();
    }

    public function getDob(): DateOfBirth
    {
        return $this->dob;
    }

    public function getRegistered(): UserRegisteredDate
    {
        return $this->registered;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCell(): string
    {
        return $this->cell;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getPicture(): UserPicture
    {
        return $this->picture;
    }

    public function getNat(): string
    {
        return $this->nat;
    }
}
