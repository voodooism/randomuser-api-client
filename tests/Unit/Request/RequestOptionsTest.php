<?php
declare(strict_types=1);

namespace Voodooism\RandomUser\Test\Unit\Request;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Voodooism\RandomUser\Enum\NationalityEnum;
use Voodooism\RandomUser\Request\RequestOptions;

class RequestOptionsTest extends TestCase
{
    public function testWrongNationality(): void
    {
        $options = new RequestOptions();

        $this->expectException(InvalidArgumentException::class);
        $options->setNat('wrong_nat');
    }

    public function testBuildQueryString(): void
    {
        $options = new RequestOptions();

        $options->setNat($nat = NationalityEnum::AU);
        $options->onlyMale();
        $options->setSeed($seed ='seed');

        $this->assertEquals(
            sprintf('seed=%s&nat=%s&gender=male', $seed, $nat),
            $options->buildQueryString()
        );
    }
}