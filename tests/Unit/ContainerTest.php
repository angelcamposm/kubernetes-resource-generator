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
