<?php

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Enums\ImagePullPolicy;
use Acamposm\KubernetesResourceGenerator\Exceptions\UnexpectedUnitSuffixException;
use Acamposm\KubernetesResourceGenerator\Resources\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private const IMAGE = 'alpine:3.16.2';
    private const NAME = 'my-container';

    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
    }

    public function testItCanCreateAnInstance(): void
    {
        $this->assertInstanceOf(Container::class, new Container());
    }

    public function testItCanAssignContainerName(): void
    {
        $this->container->name(self::NAME);

        $this->assertEquals(self::NAME, $this->container->toArray()['name']);
    }

    public function testItCanAssignContainerImage(): void
    {
        $this->container->image(self::IMAGE);

        $this->assertEquals(self::IMAGE, $this->container->toArray()['image']);
    }

    public function testItCanAssignContainerImagePullPolicy(): void
    {
        $ipp = ImagePullPolicy::IF_NOT_PRESENT;

        $this->container->imagePullPolicy($ipp);

        $this->assertEquals($ipp->value, $this->container->toArray()['imagePullPolicy']);
    }

    public function testItCanAddEnvironmentVariable(): void
    {
        $this->container->addEnvVariable('DEBUG', '*');

        $container = $this->container->toArray();

        $this->assertArrayHasKey('env', $container);
        $this->assertEquals(['name' => 'DEBUG', 'value' => '*'], $container['env'][0]);
    }

    public function testItCanAddPortToContainer(): void
    {
        $ports = [
            [
                'containerPort' => 8080,
                'name' => 'http-alt',
                'protocol' => 'TCP',
            ]
        ];

        $container = $this->container->addPorts($ports)->toArray();

        $this->assertArrayHasKey('ports', $container);
        $this->assertEquals($ports, $container['ports']);
    }

    public function testItCanAddCommands(): void
    {
        $command = ['sh', '-c', 'sleep', '60s'];

        $container = $this->container->addCommands($command)->toArray();

        $this->assertArrayHasKey('command', $container);
        $this->assertEquals($command, $container['command']);
    }

    public function testItCanSetCpuLimit(): void
    {
        $this->container->setCpuLimit(1);

        $this->assertEquals('1', $this->container->toArray()['resources']['limits']['cpu']);
    }

    public function testItCanSetCpuRequest(): void
    {
        $this->container->setCpuRequest('100m');

        $this->assertEquals('^100m^', $this->container->toArray()['resources']['requests']['cpu']);
    }

    public function testItCanSetMemoryLimit(): void
    {
        $this->container->setMemoryLimit('256Mi');

        $this->assertEquals('^256Mi^', $this->container->toArray()['resources']['limits']['memory']);
    }

    public function testItCanSetMemoryRequest(): void
    {
        $this->container->setMemoryRequest('64Mi');

        $this->assertEquals('^64Mi^', $this->container->toArray()['resources']['requests']['memory']);
    }

    public function testItCantSetWrongUnitSuffix(): void
    {
        $this->expectException(UnexpectedUnitSuffixException::class);

        $this->container->setMemoryRequest('100MB');
    }
}
