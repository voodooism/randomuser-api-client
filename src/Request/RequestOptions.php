<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\Request;

use InvalidArgumentException;
use Voodooism\RandomUser\Enum\GenderEnum;
use Voodooism\RandomUser\Enum\NationalityEnum;

class RequestOptions
{
    private ?string $gender = null;

    private ?string $seed = null;

    private ?string $nat = null;

    public function onlyMale(): void
    {
        $this->gender = GenderEnum::MALE;
    }

    public function onlyFemale(): void
    {
        $this->gender = GenderEnum::FEMALE;
    }

    public function setNat(string $nat): void
    {
        if (!NationalityEnum::contains($nat)) {
            throw new InvalidArgumentException(
                sprintf('Wrong nationality given: `%s`', $nat)
            );
        }

        $this->nat = $nat;
    }

    public function setSeed(string $seed): void
    {
        $this->seed = $seed;
    }

    public function buildQueryString(): string
    {
        $options = [
            'seed' => $this->seed,
            'nat' => $this->nat,
            'gender' => $this->gender
        ];

        return http_build_query(array_filter($options));
    }
}
