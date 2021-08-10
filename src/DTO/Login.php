<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

class Login
{
    private string $uuid;

    private string $username;

    private string $password;

    private string $salt;

    private string $md5;

    private string $sha1;

    private string $sha256;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function getMd5(): string
    {
        return $this->md5;
    }

    public function getSha1(): string
    {
        return $this->sha1;
    }

    public function getSha256(): string
    {
        return $this->sha256;
    }
}
