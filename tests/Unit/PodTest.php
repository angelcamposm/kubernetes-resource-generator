<?php

declare(strict_types=1);

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Resources\Pod;
use Acamposm\KubernetesResourceGenerator\Tests\Helpers\Reflection;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class PodTest extends TestCase
{
    protected Pod $pod;

    private const NAME = 'pod-name';
    private const NAMESPACE = 'pod-namespace';
    private const REPLICAS = 3;
    private const SERVICE_ACCOUNT = 'pod-service-account';

    protected function setUp(): void
    {
        parent::setUp();

        $this->pod = new Pod();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf(Pod::class, $this->pod);
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetPodName(): void
    {
        $this->pod->name(self::NAME);

        $this->assertEquals(
            expected: self::NAME,
            actual: Reflection::getPropertyValue($this->pod,'name')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetNamespace(): void
    {
        $this->pod->namespace(self::NAMESPACE);

        $this->assertEquals(
            expected: self::NAMESPACE,
            actual: Reflection::getPropertyValue($this->pod,'namespace')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetOsNameToLinux(): void
    {
        $this->pod->osName(Pod::OS_LINUX);

        $this->assertEquals(
            expected: Pod::OS_LINUX,
            actual: Reflection::getPropertyValue($this->pod,'osName')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetOsNameToWindows(): void
    {
        $this->pod->osName(Pod::OS_WINDOWS);

        $this->assertEquals(
            expected: Pod::OS_WINDOWS,
            actual: Reflection::getPropertyValue($this->pod,'osName')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetReplicaCount(): void
    {
        $this->pod->replicas(self::REPLICAS);

        $this->assertEquals(
            expected: self::REPLICAS,
            actual: Reflection::getPropertyValue($this->pod,'replicas')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetRestartPolicy(): void
    {
        $this->pod->restartPolicy(Pod::RP_ALWAYS);

        $this->assertEquals(
            expected: Pod::RP_ALWAYS,
            actual: Reflection::getPropertyValue($this->pod, 'restartPolicy')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetServiceAccount(): void
    {
        $this->pod->serviceAccount(self::SERVICE_ACCOUNT);

        $this->assertEquals(
            expected: self::SERVICE_ACCOUNT,
            actual: Reflection::getPropertyValue($this->pod, 'serviceAccount')
        );
    }

    public function testItCanReturnAnArrayWithFullExample(): void
    {
        $pod = $this->pod
            ->name(self::NAME)
            ->namespace(self::NAMESPACE)
            ->osName(Pod::OS_LINUX)
            ->serviceAccount(self::SERVICE_ACCOUNT)
            ->replicas(self::REPLICAS)
            ->restartPolicy(Pod::RP_ALWAYS);

        $this->assertIsArray($pod->toArray());
    }

    public function testItCanReturnAnStringWithFullExample()
    {
        $pod = $this->pod
            ->name(self::NAME)
            ->namespace(self::NAMESPACE)
            ->osName(Pod::OS_LINUX)
            ->serviceAccount(self::SERVICE_ACCOUNT)
            ->replicas(self::REPLICAS)
            ->restartPolicy(Pod::RP_ALWAYS);

        $yaml = $pod->toYaml();

        $this->assertIsString($yaml);
        $this->assertStringContainsString(self::NAME, $yaml);
        $this->assertStringContainsString(self::NAMESPACE, $yaml);
        $this->assertStringContainsString(self::SERVICE_ACCOUNT, $yaml);
        $this->assertStringContainsString(strval(self::REPLICAS), $yaml);
        $this->assertStringContainsString(Pod::OS_LINUX, $yaml);
        $this->assertStringContainsString(Pod::RP_ALWAYS, $yaml);
    }

}