<?php

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Reference\Annotations\PodAnnotations;
use PHPUnit\Framework\TestCase;

class PodAnnotationsTest extends TestCase
{
    private const CHANGE_CAUSE = 'update to version 1.2';
    private const CONTAINER = 'my-app-container';
    private const COST = 100;
    private const DESCRIPTION = 'my awesome application description';


    public function testItCanGetChangeCauseAnnotation(): void
    {
        $actual = PodAnnotations::changeCause(self::CHANGE_CAUSE);

        $expected = ['kubernetes.io/change-cause' => self::CHANGE_CAUSE];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetDeletionCostAnnotation(): void
    {
        $actual = PodAnnotations::deletionCost(self::COST);

        $expected = ['controller.kubernetes.io/pod-deletion-cost' => self::COST];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetDefaultContainerAnnotation(): void
    {
        $actual = PodAnnotations::defaultContainer(self::CONTAINER);

        $expected = ['kubectl.kubernetes.io/default-container' => self::CONTAINER];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetDescriptionAnnotation(): void
    {
        $actual = PodAnnotations::description(self::DESCRIPTION);

        $expected = ['kubernetes.io/description' => self::DESCRIPTION];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }
}
