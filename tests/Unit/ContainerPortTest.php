<?php

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Enums\Protocol;
use Acamposm\KubernetesResourceGenerator\Exceptions\PortNumberException;
use Acamposm\KubernetesResourceGenerator\Resources\ContainerPort;
use PHPUnit\Framework\TestCase;

class ContainerPortTest extends TestCase
{
    private const IP = '192.168.10.100';
    private const NAME = 'http-alt';
    private const PORT = 4000;

    private ContainerPort $containerPort;

    protected function setUp(): void
    {
        parent::setUp();
        $this->containerPort = ContainerPort::create();
    }

    public function testItCanNotCreateWithoutPortNumber(): void
    {
        $this->expectException(PortNumberException::class);
        $this->containerPort->toArray();
    }

    public function testItCanNotAssignAPortNumberLowerThanTheMinimumPortNumber(): void
    {
        $this->expectException(PortNumberException::class);

        $this->containerPort->containerPort(-135);
    }

    public function testItCanNotAssignAPPortNumberGreaterThanTheMaximumPortNumber(): void
    {
        $this->expectException(PortNumberException::class);

        $this->containerPort->containerPort(65537);
    }

    public function testItCanSetContainerPort(): void
    {
        $actual = $this->containerPort
            ->containerPort(self::PORT)
            ->toArray();

        $this->assertEquals([
            'containerPort' => self::PORT,
            'protocol' => Protocol::TCP->value
        ], $actual);
    }

    public function testItCanSetContainerPortAndHostIP(): void
    {
        $actual = $this->containerPort
            ->containerPort(4000)
            ->hostIp(self::IP)
            ->toArray();

        $this->assertEquals([
            'containerPort' => self::PORT,
            'protocol' => Protocol::TCP->value,
            'hostIp' => self::IP,
        ], $actual);
    }

    public function testItCanSetContainerPortAndHostPort(): void
    {
        $actual = $this->containerPort
            ->containerPort(4000)
            ->protocol(Protocol::TCP)
            ->hostPort(self::PORT)
            ->toArray();

        $this->assertEquals([
            'containerPort' => self::PORT,
            'protocol' => Protocol::TCP->value,
            'hostPort' => self::PORT,
        ], $actual);
    }

    public function testItCanSetContainerPortAndName(): void
    {
        $actual = $this->containerPort
            ->containerPort(self::PORT)
            ->name(self::NAME)
            ->toArray();

        $this->assertEquals([
            'containerPort' => self::PORT,
            'protocol' => Protocol::TCP->value,
            'name' => self::NAME,
        ], $actual);
    }

    public function testItCanSetContainerPortAndProtocol(): void
    {
        $actual = $this->containerPort
            ->containerPort(self::PORT)
            ->protocol(Protocol::UDP)
            ->toArray();

        $this->assertEquals([
            'containerPort' => self::PORT,
            'protocol' => Protocol::UDP->value,
        ], $actual);
    }
}
