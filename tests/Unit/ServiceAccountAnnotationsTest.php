<?php

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Reference\Annotations\ServiceAccountAnnotations;
use PHPUnit\Framework\TestCase;

class ServiceAccountAnnotationsTest extends TestCase
{
    public const DESCRIPTION = 'ServiceAccount description';

    public function testItCanGetServiceAccountDescriptionAnnotation(): void
    {
        $actual = ServiceAccountAnnotations::description(self::DESCRIPTION);

        $expected = ['kubernetes.io/description' => self::DESCRIPTION];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetEnforceMountableSecretsAnnotation(): void
    {
        $actual = ServiceAccountAnnotations::enforceMountableSecrets();

        $expected = ['kubernetes.io/enforce-mountable-secrets' => 'true'];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }
}
