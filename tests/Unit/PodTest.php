<?php

declare(strict_types=1);

namespace Acamposm\KubernetesResourceGenerator\Tests\Unit;

use Acamposm\KubernetesResourceGenerator\Enums\OperatingSystem;
use Acamposm\KubernetesResourceGenerator\Enums\RestartPolicy;
use Acamposm\KubernetesResourceGenerator\Resources\Pod;
use Acamposm\KubernetesResourceGenerator\Tests\Helpers\Reflection;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class PodTest extends TestCase
{
    protected Pod $pod;

    private const PRIMARY_IMAGE_PULL_SECRET = 'my-private-registry-access-token';
    private const SECONDARY_IMAGE_PULL_SECRET = 'my-secondary-access-token';
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
        $this->pod->osName(OperatingSystem::LINUX);

        $this->assertEquals(
            expected: OperatingSystem::LINUX->value,
            actual: Reflection::getPropertyValue($this->pod,'osName')
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanSetOsNameToWindows(): void
    {
        $this->pod->osName(OperatingSystem::WINDOWS);

        $this->assertEquals(
            expected: OperatingSystem::WINDOWS->value,
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
        $this->pod->restartPolicy(RestartPolicy::ALWAYS);

        $this->assertEquals(
            expected: RestartPolicy::ALWAYS->value,
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

    /**
     * @throws ReflectionException
     */
    public function testItCanSetImagePullSecret(): void
    {
        $this->pod->addImagePullSecret(self::PRIMARY_IMAGE_PULL_SECRET);

        $this->assertEquals(
            expected: ['name' => self::PRIMARY_IMAGE_PULL_SECRET],
            actual: Reflection::getPropertyValue($this->pod, 'imagePullSecrets')[0]
        );
    }

    public function testItCanSetImagePullSecrets(): void
    {
        $secrets = [
            ['name' => self::PRIMARY_IMAGE_PULL_SECRET],
            ['name' => self::SECONDARY_IMAGE_PULL_SECRET],
        ];

        $pod = $this->pod
            ->name(self::NAME)
            ->addImagePullSecrets([
                self::PRIMARY_IMAGE_PULL_SECRET,
                self::SECONDARY_IMAGE_PULL_SECRET,
            ])
            ->toArray();

        $this->assertIsArray($pod);
        $this->assertArrayHasKey('spec', $pod);
        $this->assertArrayHasKey('imagePullSecrets', $pod['spec']);
        $this->assertEquals($secrets, $pod['spec']['imagePullSecrets']);
    }

    public function testItCanReturnAnArrayWithFullExample(): void
    {
        $pod = $this->pod
            ->name(self::NAME)
            ->namespace(self::NAMESPACE)
            ->osName(OperatingSystem::LINUX)
            ->serviceAccount(self::SERVICE_ACCOUNT)
            ->replicas(self::REPLICAS)
            ->restartPolicy(RestartPolicy::ALWAYS);

        $this->assertIsArray($pod->toArray());
    }

    public function testItCanReturnAnStringWithFullExample()
    {
        $pod = $this->pod
            ->name(self::NAME)
            ->namespace(self::NAMESPACE)
            ->osName(OperatingSystem::LINUX)
            ->serviceAccount(self::SERVICE_ACCOUNT)
            ->replicas(self::REPLICAS)
            ->restartPolicy(RestartPolicy::ALWAYS);

        $yaml = $pod->toYaml();

        $this->assertIsString($yaml);
        $this->assertStringContainsString(self::NAME, $yaml);
        $this->assertStringContainsString(self::NAMESPACE, $yaml);
        $this->assertStringContainsString(self::SERVICE_ACCOUNT, $yaml);
        $this->assertStringContainsString(strval(self::REPLICAS), $yaml);
        $this->assertStringContainsString(OperatingSystem::LINUX->value, $yaml);
        $this->assertStringContainsString(RestartPolicy::ALWAYS->value, $yaml);
    }

}
