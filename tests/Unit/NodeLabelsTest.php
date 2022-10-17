<?php

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Reference\Labels\NodeLabels;
use PHPUnit\Framework\TestCase;

class NodeLabelsTest extends TestCase
{
    private const REGION = 'us-east-1';
    private const ZONE = 'us-east-1a';

    /**
     * @group Kubernetes Reference
     * @return void
     */
    public function testItCanGetRegionLabel(): void
    {
        $actual = NodeLabels::region(self::REGION);

        $expected = ['topology.kubernetes.io/region' => self::REGION];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @group Kubernetes Reference
     * @return void
     */
    public function testItCanGetZoneLabel(): void
    {
        $actual = NodeLabels::zone(self::ZONE);

        $expected = ['topology.kubernetes.io/zone' => self::ZONE];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }
}
