<?php

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Exceptions\InvalidIpAddressException;
use Acamposm\KubernetesResourceGenerator\Helpers\HostAlias;
use PHPUnit\Framework\TestCase;

class HostAliasTest extends testCase
{
    public function testItCanNotAssignInvalidIpAddress(): void
    {
        $this->expectException(InvalidIpAddressException::class);

        HostAlias::get('localhost', '265.0.0.0');
    }
}
