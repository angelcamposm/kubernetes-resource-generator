<?php

namespace Acamposm\KubernetesResourceGenerator\Tests\Integration;

use Acamposm\KubernetesResourceGenerator\Resources\Container;
use Acamposm\KubernetesResourceGenerator\Resources\Pod;
use PHPUnit\Framework\TestCase;

class addContainersToPodTest extends TestCase
{
    private Container $container;
    private Pod $pod;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
        $this->pod = new Pod();
    }

    public function testItCanAddContainerToPod(): void
    {
        $container = $this->container
            ->name('alpine-container')
            ->image('alpine:3.16.2')
            ->toArray();

        $pod = $this->pod
            ->name('example-pod')
            ->addContainers($container)
            ->toArray();

        $this->assertIsArray($container);
        $this->assertIsArray($pod);
        $this->assertArrayHasKey('spec', $pod);
        $this->assertArrayHasKey('containers', $pod['spec']);
        $this->assertEquals($container, $pod['spec']['containers']);
    }
}
