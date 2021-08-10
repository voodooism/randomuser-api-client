<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\DTO;

use DateTimeImmutable;
use JMS\Serializer\Annotation as Serializer;

class DateOfBirth
{
    /**
     * @Serializer\Type("DateTimeImmutable<'Y-m-d\TH:i:s.uP', '', 'Y-m-d\TH:i:s.uP'>")
     */
    private DateTimeImmutable $date;

    private int $age;

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}
