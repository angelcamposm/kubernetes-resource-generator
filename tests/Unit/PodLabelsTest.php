<?php

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Reference\Labels\PodLabels;
use PHPUnit\Framework\TestCase;

class PodLabelsTest extends TestCase
{
    private const COMPONENT = 'application';
    private const INSTANCE = 'my-app-xyz';
    private const MANAGED_BY = 'Kustomize.io';
    private const NAME = 'my-app-frontend';
    private const PART_OF = 'my-awesome-application';
    private const VERSION = '1.2.123';

    public function testItCanGetComponentLabel(): void
    {
        $actual = PodLabels::component(self::COMPONENT);

        $expected = ['app.kubernetes.io/component' => self::COMPONENT];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetInstanceLabel(): void
    {
        $actual = PodLabels::instance(self::INSTANCE);

        $expected = ['app.kubernetes.io/instance' => self::INSTANCE];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetManagedByLabel(): void
    {
        $actual = PodLabels::managedBy(self::MANAGED_BY);

        $expected = ['app.kubernetes.io/managed-by' => self::MANAGED_BY];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetNameLabel(): void
    {
        $actual = PodLabels::name(self::NAME);

        $expected = ['app.kubernetes.io/name' => self::NAME];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetPartOfLabel(): void
    {
        $actual = PodLabels::partOf(self::PART_OF);

        $expected = ['app.kubernetes.io/part-of' => self::PART_OF];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetVersionLabel(): void
    {
        $actual = PodLabels::version(self::VERSION);

        $expected = ['app.kubernetes.io/version' => self::VERSION];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetSafeToEvictLabel(): void
    {
        $actual = PodLabels::safeToEvict();

        $expected = ['cluster-autoscaler.kubernetes.io/safe-to-evict' => 'true'];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetUnsafeToEvictLabel(): void
    {
        $actual = PodLabels::unsafeToEvict();

        $expected = ['cluster-autoscaler.kubernetes.io/safe-to-evict' => 'false'];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }
}
